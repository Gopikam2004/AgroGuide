from ast import main
import pandas as pd
import streamlit as st
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier

# Title of the app
st.title('Enter Soil Test Results')

# Load the dataset
data = pd.read_csv('crop_data.csv')

# Prepare features and labels
X = data[['ph', 'sodium', 'potassium', 'nitrogen']]
y = data['crop']

# Split dataset into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train decision tree classifier
model = DecisionTreeClassifier()
model.fit(X_train, y_train)
# Input fields for pH, Potassium, Sodium, and Nitrogen
ph = st.number_input("Enter pH value", min_value=0.0, max_value=14.0, step=0.1)
potassium = st.number_input("Enter Potassium value", min_value=0.0, max_value=100.0, value=0.0, step=0.1)
sodium = st.number_input("Enter Sodium value", min_value=0.0, max_value=100.0, value=0.0, step=0.1)
nitrogen = st.number_input("Enter Nitrogen value", min_value=0.0, max_value=100.0, value=0.0, step=0.1)

def predict_crop(ph, sodium, potassium, nitrogen):
    # Prepare features for prediction
    X_new = pd.DataFrame({'ph': [ph], 'sodium': [sodium], 'potassium': [potassium], 'nitrogen': [nitrogen]})
    # Make predictions
    predictions = model.predict(X_new)
    # Return the predicted crop
    return predictions[0]

crops = predict_crop(ph, sodium, potassium, nitrogen)
# Display the entered values
#if st.button("Submit", type="primary"):
 # st.write(f"Suggested Crop: {crops[0]}")
  #st.image(crops[0]+'.jpeg', caption=crops[0])
  #st.write(f"Crop: {crops[0]}")

def get_crop_info(crop_name):
    crop_info = data[data['crop'] == crop_name].iloc[0]
    return  crop_info['youtube_link']

# Display the entered values and predict the crop
if st.button("Submit", type="primary"):
    if ph <= 0.0 or sodium <= 0.0 or potassium<= 0.0 or nitrogen <= 0.0:
        st.warning("Please enter valid soil test parameters. All values must be greater than zero.")
    else:

       suggested_crop = predict_crop(ph, sodium, potassium, nitrogen)
       st.write(f"Suggested Crop: {suggested_crop}")
       st.image(suggested_crop+'.jpeg', caption=suggested_crop)
       youtube_link = get_crop_info(suggested_crop)
       st.markdown(f"[How to cultivate {suggested_crop}]({youtube_link})", unsafe_allow_html=True)

# Optional: Display additional information about crops
if st.checkbox("Other Crops Cultivaion Information"):
    st.header("Crop Cultivation Information")
    selected_crop = st.selectbox("Select a crop", data['crop'].unique())
    if st.button("Get Info"):
        youtube_link = get_crop_info(selected_crop)
        st.markdown(f"[How to cultivate {selected_crop}]({youtube_link})", unsafe_allow_html=True)

if __name__ == "main":
    main()