Testing the API
You can use tools like Postman or cURL to test your API endpoints:

GET all items
GET http://your-server/api.php

GET a single item by ID
GET http://your-server/api.php?id=1

POST a new item
POST http://your-server/api.php
Body: {"title": "New Item", "description": "This is a new item"}

PUT (update) an item
PUT http://your-server/api.php?id=1
Body: {"title": "Updated Item", "description": "This is an updated item", "completed": true}

DELETE an item
DELETE http://your-server/api.php?id=1


This basic example demonstrates how to create a simple RESTful API using PHP. You can extend this by adding more features, such as authentication, validation, and error handling.