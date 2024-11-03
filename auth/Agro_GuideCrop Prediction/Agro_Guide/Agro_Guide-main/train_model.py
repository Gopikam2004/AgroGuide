import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score
import joblib
import pickle
with open('crop_suggestion_model.pkl', 'rb') as f:
    model = pickle.load(f)

# Load dataset
data = pd.read_csv('crop_data.csv')

# Prepare features and labels
X = data[['ph', 'sodium', 'potassium']]
y = data['crop']

# Split dataset into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train decision tree classifier
model = DecisionTreeClassifier()
model.fit(X_train, y_train)

# Evaluate model
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print("Model Accuracy:", accuracy)

# Save trained model
joblib.dump(model, 'crop_suggestion_model.pkl',compress=True)
