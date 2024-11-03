import pandas as pd
import joblib

# Load the trained model
model = joblib.load('Agro_Guide-main/crop_suggestion_model.pkl')

def predict_crops(ph, sodium, potassium):
    # Prepare features for prediction
    X_new = pd.DataFrame({'ph': [ph], 'sodium': [sodium], 'potassium': [potassium]})
    
    # Make predictions
    predictions = model.predict(X_new)
    
    # Return the predicted crops
    return predictions

def main():
    print("Welcome to Crop Prediction System")
    print("Please input your soil parameters:")
    ph = float(input("pH: "))
    sodium = float(input("Sodium: "))
    potassium = float(input("Potassium: "))
    
    # Get predicted crops
    crops = predict_crops(ph, sodium, potassium)
    
    print("Predicted crops:", crops)

if __name__ == "__main__":
    main()