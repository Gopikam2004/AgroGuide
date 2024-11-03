import streamlit as st
import pandas as pd
from sklearn.tree import DecisionTreeClassifier

# Load the trained model
model = DecisionTreeClassifier()  # Use your trained model

# Load your dataset (or the feature columns required for prediction)
data = pd.read_csv('Crop_recommendation.csv')
feature_columns = data.drop('Crop', axis=1).columns

def predict_crop(input_data):
    input_df = pd.DataFrame([input_data])
    prediction = model.predict(input_df)
    return prediction[0]

# Streamlit app
st.title("Crop Recommendation API")

if 'soil_type' in st.experimental_get_query_params():
    user_input = {feature: st.experimental_get_query_params().get(feature, [0])[0] for feature in feature_columns}
    user_input = {k: float(v) for k, v in user_input.items()}
    result = predict_crop(user_input)
    st.write(result)
