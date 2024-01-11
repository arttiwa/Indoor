from ultralytics import YOLO

# Initialize YOLOv8 model
model = YOLO('sign_model.pt')

# Get all class names
class_names = model.names

# Print the class names and their corresponding indices
for index, name in class_names.items():
    print(f"Class Index: {index}, Class Name: {name}")
