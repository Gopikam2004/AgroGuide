import pandas as pd
import joblib

# Load the trained model
model = joblib.load("C:/Desktop/try/Agro_Guide-main/crop_suggestion_model.pkl")

# Load the new data for prediction (you can load it from a CSV file or any other source)
# For demonstration purposes, let's assume new data is in a CSV file named 'new_data.csv'
new_data = pd.read_csv('Agro_Guide-main/crop_data.csv')

# Prepare features for prediction
X_new = new_data[['ph', 'sodium', 'potassium']]

# Make predictions
predictions = model.predict(X_new)

# Output the predicted crops
print("Predicted crops:")
for prediction in predictions:
    print(prediction)