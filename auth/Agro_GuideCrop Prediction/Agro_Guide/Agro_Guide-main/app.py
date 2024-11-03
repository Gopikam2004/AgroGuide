from flask import Flask, request, jsonify, render_template
import joblib

app = Flask(__name__, template_folder='template', static_folder='static')

# Initialize model variable
model = None

def load_model():
    global model
    try:
        # Load trained model from file
        model = joblib.load('Agro_Guide-main/crop_suggestion_model.pkl')
    except Exception as e:
        # Log the error
        app.logger.error(f"Error loading model: {e}")

# Define function to map numeric prediction to crop names
def get_crop_name(prediction):
    # Implement logic to map prediction to crop names
    crop_mapping = {0: 'Wheat', 1: 'Corn', 2: 'Rice'}
    return crop_mapping.get(prediction, 'Unknown')

@app.route('/')
def index():
    return render_template("index.html")

# Route for processing soil parameters and predicting crops
@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        ph = float(data['ph'])  # Convert to float
        sodium = float(data['sodium'])  # Convert to float
        potassium = float(data['potassium'])  # Convert to float

        # Make prediction using the loaded model
        input_features = [[ph, sodium, potassium]]
        prediction = model.predict(input_features)

        # Convert numeric prediction to crop name
        suggested_crop = get_crop_name(prediction[0])

        return jsonify({'suggested_crop': suggested_crop})
    except Exception as e:
        # Log the error
        app.logger.error(f"Prediction error: {e}")
        return jsonify({'error': 'Prediction failed'}), 500

# Route to render the page displaying suggested crops
@app.route('/result')
def result():
    # Render the template for displaying suggested crops
    return render_template('result.html')

# Route to render the login page
@app.route('/newpage')
def newpage():
    # Render the login page
    return render_template('newpage.html')

# Route to render the registration page


# Route to render the soil analysis page
@app.route('/soil-analysis')
def soil_analysis():
    # Render the soil analysis page
    return render_template('newpage.html')




if __name__ == '_main_':
    load_model()  # Load model before running the app
    app.run(debug=True)