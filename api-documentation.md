FORMAT: 1A

# API

# Authentication [/auth]

## Login user [POST /auth/login]
Login user with a `email` and `password`.
Token is returned which will be required in every request

+ Request (application/json)
    + Body

            {
                "email": "user1@mailinator.com",
                "password": "123456"
            }

+ Response 200 (application/json)
    + Body

            {
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJlMDk1YjRlMS1hNjdhLTRiZDQtOTQ5OS03YWRjN2IxNzVkODQiLCJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ5NDU4NjE4MywiZXhwIjoxNDk0NTg5NzgzLCJuYmYiOjE0OTQ1ODYxODMsImp0aSI6IkNQZVFFbzA1YkwwRGswNVoifQ.RouE5IpWIGsuxshQ3U5q1LzMivN9KfGPA93LpdadbRM",
                "user": {
                    "id": "e095b4e1-a67a-4bd4-9499-7adc7b175d84",
                    "username": "tgorczany",
                    "email": "lee52@example.org",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?99996",
                    "firstname": "Norma",
                    "surname": "Langworth",
                    "created_at": "2017-05-12 10:43:35"
                }
            }

+ Response 401 (application/json)
    + Body

            {
                "error": "invalid_credentials",
                "message": "Invalid credentials",
                "status_code": 401
            }

+ Response 500 (application/json)
    + Body

            {
                "error": "could_not_create_token",
                "message": "Internal Server Error",
                "status_code": 500
            }

# Users [/users]

## Users List [GET /users]


+ Response 200 (application/json)
    + Body

            {
                "total": 10,
                "per_page": 20,
                "current_page": 1,
                "last_page": 10,
                "next_page_url": "http:\/\/localhost:8000\/api\/users?page=2",
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "0b2db6ac-e596-4981-b39a-2cbfafc996ea",
                        "username": "betty.rath",
                        "email": "elmo.wiegand@example.net",
                        "avatar": "http:\/\/lorempixel.com\/640\/480\/?30446",
                        "firstname": "Madison",
                        "surname": "Ortiz",
                        "created_at": "2017-05-12 10:43:35"
                    }
                ]
            }

## Show User Details [GET /users/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "user": {
                    "id": "0b2db6ac-e596-4981-b39a-2cbfafc996ea",
                    "username": "betty.rath",
                    "email": "elmo.wiegand@example.net",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?30446",
                    "firstname": "Madison",
                    "surname": "Ortiz",
                    "created_at": "2017-05-12 10:43:35"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\User] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Update User Information [PUT /users/{id}]


+ Parameters
    + username: (string, optional) - 
    + email: (string, optional) - 
    + surname: (string, optional) - 
    + firstname: (string, optional) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "username": "betty.rath",
                "email": "elmo.wiegand@example.net",
                "firstname": "Madison",
                "surname": "Ortiz"
            }

+ Response 200 (application/json)
    + Body

            {
                "user": {
                    "id": "0b2db6ac-e596-4981-b39a-2cbfafc996ea",
                    "username": "betty.rath",
                    "email": "elmo.wiegand@example.net",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?30446",
                    "firstname": "Madison",
                    "surname": "Ortiz",
                    "created_at": "2017-05-12 10:43:35"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not update user information.",
                "errors": {
                    "email": [
                        "The email has already been taken."
                    ]
                },
                "status_code": 422
            }

## Delete User [DELETE /users/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "user": {
                    "id": "0b2db6ac-e596-4981-b39a-2cbfafc996ea",
                    "username": "betty.rath",
                    "email": "elmo.wiegand@example.net",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?30446",
                    "firstname": "Madison",
                    "surname": "Ortiz",
                    "created_at": "2017-05-12 10:43:35"
                }
            }

# Clients [/clients]

## List of Clients [GET /clients]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 10,
                "per_page": 20,
                "current_page": 1,
                "last_page": 10,
                "next_page_url": "http:\/\/localhost:8000\/api\/clients?page=2",
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                        "username": "coreilly",
                        "email": "kaia.bayer@example.com",
                        "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                        "firstname": "Ludie",
                        "surname": "Pfannerstill",
                        "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                        "gender": "male",
                        "dob": "1989-03-11",
                        "mobile": "292.300.8518 x37716",
                        "landline": "+1 (506) 201-8955",
                        "emergency_contact_name": null,
                        "emergency_contact_relationship": null,
                        "emergency_contact_number": null,
                        "contraindications": null,
                        "notes": null,
                        "created_at": "2017-05-12 10:43:44"
                    }
                ]
            }

## Add Client [POST /clients/{id}]


+ Parameters
    + username: (string, required) - 
    + email: (string, required) - 
    + password: (string, required) - 
    + surname: (string, optional) - 
    + firstname: (string, optional) - 
    + address: (string, optional) - 
    + gender: (string, optional) - Its value is either male or female
    + dob: (string, optional) - format is Y-m-d
    + mobile: (string, optional) - 
    + landline: (string, optional) - 
    + emergency_contact_name: (string, optional) - 
    + emergency_contact_relationship: (string, optional) - 
    + emergency_contact_number: (string, optional) - 
    + contraindications: (string, optional) - 
    + notes: (string, optional) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "username": "betty.rath",
                "password": "123456",
                "email": "elmo.wiegand@example.net",
                "firstname": "Madison",
                "surname": "Ortiz"
            }

+ Response 200 (application/json)
    + Body

            {
                "client": {
                    "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "username": "coreilly",
                    "email": "kaia.bayer@example.com",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                    "firstname": "Ludie",
                    "surname": "Pfannerstill",
                    "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                    "gender": "male",
                    "dob": "1989-03-11",
                    "mobile": "292.300.8518 x37716",
                    "landline": "+1 (506) 201-8955",
                    "emergency_contact_name": null,
                    "emergency_contact_relationship": null,
                    "emergency_contact_number": null,
                    "contraindications": null,
                    "notes": null,
                    "created_at": "2017-05-12 10:43:44"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not update user information.",
                "errors": {
                    "email": [
                        "The email has already been taken."
                    ]
                },
                "status_code": 422
            }

## Show Client Details [GET /clients/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "client": {
                    "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "username": "coreilly",
                    "email": "kaia.bayer@example.com",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                    "firstname": "Ludie",
                    "surname": "Pfannerstill",
                    "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                    "gender": "male",
                    "dob": "1989-03-11",
                    "mobile": "292.300.8518 x37716",
                    "landline": "+1 (506) 201-8955",
                    "emergency_contact_name": null,
                    "emergency_contact_relationship": null,
                    "emergency_contact_number": null,
                    "contraindications": null,
                    "notes": null,
                    "created_at": "2017-05-12 10:43:44"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Client] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Update Client Details [PUT /clients/{id}]


+ Parameters
    + username: (string, required) - 
    + email: (string, required) - 
    + surname: (string, optional) - 
    + firstname: (string, optional) - 
    + address: (string, optional) - 
    + gender: (string, optional) - Its value is either male or female
    + dob: (string, optional) - format is Y-m-d
    + mobile: (string, optional) - 
    + landline: (string, optional) - 
    + emergency_contact_name: (string, optional) - 
    + emergency_contact_relationship: (string, optional) - 
    + emergency_contact_number: (string, optional) - 
    + contraindications: (string, optional) - 
    + notes: (string, optional) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "username": "betty.rath",
                "email": "elmo.wiegand@example.net",
                "firstname": "Madison",
                "surname": "Ortiz"
            }

+ Response 200 (application/json)
    + Body

            {
                "client": {
                    "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "username": "coreilly",
                    "email": "kaia.bayer@example.com",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                    "firstname": "Ludie",
                    "surname": "Pfannerstill",
                    "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                    "gender": "male",
                    "dob": "1989-03-11",
                    "mobile": "292.300.8518 x37716",
                    "landline": "+1 (506) 201-8955",
                    "emergency_contact_name": null,
                    "emergency_contact_relationship": null,
                    "emergency_contact_number": null,
                    "contraindications": null,
                    "notes": null,
                    "created_at": "2017-05-12 10:43:44"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not update user information.",
                "errors": {
                    "email": [
                        "The email has already been taken."
                    ]
                },
                "status_code": 422
            }

## Delete Client [DELETE /clients/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "client": {
                    "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "username": "coreilly",
                    "email": "kaia.bayer@example.com",
                    "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                    "firstname": "Ludie",
                    "surname": "Pfannerstill",
                    "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                    "gender": "male",
                    "dob": "1989-03-11",
                    "mobile": "292.300.8518 x37716",
                    "landline": "+1 (506) 201-8955",
                    "emergency_contact_name": null,
                    "emergency_contact_relationship": null,
                    "emergency_contact_number": null,
                    "contraindications": null,
                    "notes": null,
                    "created_at": "2017-05-12 10:43:44"
                }
            }

# Measurements [/measurements]

## List of Measurements of Client [GET /measurements/client/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 1,
                "per_page": 20,
                "current_page": 1,
                "last_page": 1,
                "next_page_url": null,
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "074201ab-aeb6-4c45-b6e4-a9a4ac70019c",
                        "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                        "bmi": "14.02",
                        "bmr": "50.00",
                        "body_fat": "14.00",
                        "calf": "15.00",
                        "chest": "15.00",
                        "height": "15.00",
                        "shoulders": "15.00",
                        "thigh": "15.00",
                        "upper_arm": "15.00",
                        "waist": "15.00",
                        "weight": "180.00",
                        "goals": null,
                        "notes": null,
                        "measurement_date": "2017-05-15 00:00:00",
                        "deleted_at": null,
                        "created_at": "2017-05-13 10:25:45",
                        "updated_at": "2017-05-13 10:25:45"
                    }
                ]
            }

## Add Measurement [POST /measurements]


+ Parameters
    + client_id: (string, required) - 
    + bmi: (float, required) - 
    + bmr: (float, required) - 
    + body_fat: (float, required) - 
    + calf: (float, required) - 
    + chest: (float, required) - 
    + height: (float, required) - 
    + shoulders: (float, required) - 
    + thigh: (float, required) - 
    + upper_arm: (float, required) - 
    + waist: (float, required) - 
    + weight: (float, required) - 
    + measurement_date: (date, required) - date format is Y-m-d

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                "bmi": 14.02,
                "bmr": 50,
                "body_fat": 14,
                "calf": 15,
                "chest": 15,
                "height": 15,
                "shoulders": 15,
                "thigh": 15,
                "upper_arm": 15,
                "waist": 15,
                "weight": 180,
                "measurement_date": "2017-05-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "measurement": {
                    "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                    "bmi": 14.02,
                    "bmr": 50,
                    "body_fat": 14,
                    "calf": 15,
                    "chest": 15,
                    "height": 15,
                    "shoulders": 15,
                    "thigh": 15,
                    "upper_arm": 15,
                    "waist": 15,
                    "weight": 180,
                    "measurement_date": "2017-05-15 00:00:00",
                    "id": "074201ab-aeb6-4c45-b6e4-a9a4ac70019c",
                    "updated_at": "2017-05-13 10:25:45",
                    "created_at": "2017-05-13 10:25:45"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add measurement information.",
                "errors": {
                    "bmi": [
                        "The bmi field is required."
                    ],
                    "bmr": [
                        "The bmr field is required."
                    ],
                    "body_fat": [
                        "The body fat field is required."
                    ],
                    "calf": [
                        "The calf field is required."
                    ],
                    "chest": [
                        "The chest field is required."
                    ],
                    "height": [
                        "The height field is required."
                    ],
                    "shoulders": [
                        "The shoulders field is required."
                    ],
                    "thigh": [
                        "The thigh field is required."
                    ],
                    "upper_arm": [
                        "The upper arm field is required."
                    ],
                    "waist": [
                        "The waist field is required."
                    ],
                    "weight": [
                        "The weight field is required."
                    ],
                    "measurement_date": [
                        "The measurement date field is required."
                    ]
                },
                "status_code": 422
            }

## Show Measurement Details [GET /measurements]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "measurement": {
                    "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                    "bmi": 14.02,
                    "bmr": 50,
                    "body_fat": 14,
                    "calf": 15,
                    "chest": 15,
                    "height": 15,
                    "shoulders": 15,
                    "thigh": 15,
                    "upper_arm": 15,
                    "waist": 15,
                    "weight": 180,
                    "measurement_date": "2017-05-15 00:00:00",
                    "id": "074201ab-aeb6-4c45-b6e4-a9a4ac70019c",
                    "updated_at": "2017-05-13 10:25:45",
                    "created_at": "2017-05-13 10:25:45"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Update Measurement [PUT /measurements/{id}]


+ Parameters
    + client_id: (string, required) - 
    + bmi: (float, required) - 
    + bmr: (float, required) - 
    + body_fat: (float, required) - 
    + calf: (float, required) - 
    + chest: (float, required) - 
    + height: (float, required) - 
    + shoulders: (float, required) - 
    + thigh: (float, required) - 
    + upper_arm: (float, required) - 
    + waist: (float, required) - 
    + weight: (float, required) - 
    + measurement_date: (date, required) - date format is Y-m-d

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                "bmi": 14.02,
                "bmr": 50,
                "body_fat": 14,
                "calf": 15,
                "chest": 15,
                "height": 15,
                "shoulders": 15,
                "thigh": 15,
                "upper_arm": 15,
                "waist": 15,
                "weight": 180,
                "measurement_date": "2017-05-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "measurement": {
                    "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                    "bmi": 14.02,
                    "bmr": 50,
                    "body_fat": 14,
                    "calf": 15,
                    "chest": 15,
                    "height": 15,
                    "shoulders": 15,
                    "thigh": 15,
                    "upper_arm": 15,
                    "waist": 15,
                    "weight": 180,
                    "measurement_date": "2017-05-15 00:00:00",
                    "id": "074201ab-aeb6-4c45-b6e4-a9a4ac70019c",
                    "updated_at": "2017-05-13 10:25:45",
                    "created_at": "2017-05-13 10:25:45"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add measurement information.",
                "errors": {
                    "bmi": [
                        "The bmi field is required."
                    ],
                    "bmr": [
                        "The bmr field is required."
                    ],
                    "body_fat": [
                        "The body fat field is required."
                    ],
                    "calf": [
                        "The calf field is required."
                    ],
                    "chest": [
                        "The chest field is required."
                    ],
                    "height": [
                        "The height field is required."
                    ],
                    "shoulders": [
                        "The shoulders field is required."
                    ],
                    "thigh": [
                        "The thigh field is required."
                    ],
                    "upper_arm": [
                        "The upper arm field is required."
                    ],
                    "waist": [
                        "The waist field is required."
                    ],
                    "weight": [
                        "The weight field is required."
                    ],
                    "measurement_date": [
                        "The measurement date field is required."
                    ]
                },
                "status_code": 422
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Delete Measurement [DELETE /measurements/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "measurement": {
                    "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                    "bmi": 14.02,
                    "bmr": 50,
                    "body_fat": 14,
                    "calf": 15,
                    "chest": 15,
                    "height": 15,
                    "shoulders": 15,
                    "thigh": 15,
                    "upper_arm": 15,
                    "waist": 15,
                    "weight": 180,
                    "measurement_date": "2017-05-15 00:00:00",
                    "id": "074201ab-aeb6-4c45-b6e4-a9a4ac70019c",
                    "updated_at": "2017-05-13 10:25:45",
                    "created_at": "2017-05-13 10:25:45"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Measurement] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

# Bookings [/bookings]

## List of Bookings [GET /bookings]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 1,
                "per_page": 20,
                "current_page": 1,
                "last_page": 1,
                "next_page_url": null,
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "abfc3482-1080-48d2-87e4-75492de8ffbd",
                        "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                        "booking_date": "2017-05-25",
                        "start_time": "05:05:00",
                        "finish_time": "06:55:00",
                        "cancelled": false,
                        "deleted_at": null,
                        "created_at": "2017-05-15 05:38:47",
                        "updated_at": "2017-05-15 05:38:47",
                        "clients": [
                            {
                                "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                "username": "coreilly",
                                "email": "kaia.bayer@example.com",
                                "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                                "firstname": "Ludie",
                                "surname": "Pfannerstill",
                                "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                                "gender": "male",
                                "dob": "1989-03-11",
                                "mobile": "292.300.8518 x37716",
                                "landline": "+1 (506) 201-8955",
                                "emergency_contact_name": null,
                                "emergency_contact_relationship": null,
                                "emergency_contact_number": null,
                                "contraindications": null,
                                "notes": null,
                                "created_at": "2017-05-12 10:43:44",
                                "pivot": {
                                    "booking_id": "abfc3482-1080-48d2-87e4-75492de8ffbd",
                                    "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                    "paid": "0",
                                    "created_at": "2017-05-15 05:38:47",
                                    "updated_at": "2017-05-15 05:38:47"
                                }
                            },
                            {
                                "id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                "username": "ernestine82",
                                "email": "chloe43@example.org",
                                "avatar": "http:\/\/lorempixel.com\/640\/480\/?82996",
                                "firstname": "Kiara",
                                "surname": "Johnson",
                                "address": "63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512",
                                "gender": "male",
                                "dob": "1985-12-12",
                                "mobile": "331-762-7069 x74990",
                                "landline": "480.844.9263 x62498",
                                "emergency_contact_name": null,
                                "emergency_contact_relationship": null,
                                "emergency_contact_number": null,
                                "contraindications": null,
                                "notes": null,
                                "created_at": "2017-05-12 10:43:44",
                                "pivot": {
                                    "booking_id": "abfc3482-1080-48d2-87e4-75492de8ffbd",
                                    "client_id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                    "paid": "0",
                                    "created_at": "2017-05-15 05:38:47",
                                    "updated_at": "2017-05-15 05:38:47"
                                }
                            }
                        ]
                    }
                ]
            }

## List of Bookings of Client [GET /bookings/client/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 1,
                "per_page": 20,
                "current_page": 1,
                "last_page": 1,
                "next_page_url": null,
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "abfc3482-1080-48d2-87e4-75492de8ffbd",
                        "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                        "booking_date": "2017-05-25",
                        "start_time": "05:05:00",
                        "finish_time": "06:55:00",
                        "cancelled": false,
                        "deleted_at": null,
                        "created_at": "2017-05-15 05:38:47",
                        "updated_at": "2017-05-15 05:38:47",
                        "pivot": {
                            "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                            "booking_id": "abfc3482-1080-48d2-87e4-75492de8ffbd",
                            "paid": "0",
                            "created_at": "2017-05-15 05:38:47",
                            "updated_at": "2017-05-15 05:38:47"
                        }
                    }
                ]
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Client] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Add Booking [POST /bookings]


+ Parameters
    + clients: (array, required) - Ids of client
    + session_type_id: (string, required) - 
    + booking_date: (date, required) - Format is Y-m-d
    + start_time: (time, required) - Format is H:i
    + finish_time: (time, required) - Format is H:i

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "clients": [
                    "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "bf8b12ef-6352-44dd-afcd-3db8bef07678"
                ],
                "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                "start_time": "05:05",
                "finish_time": "06:55",
                "booking_date": "2017-05-25"
            }

+ Response 200 (application/json)
    + Body

            {
                "booking": {
                    "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                    "start_time": "05:05",
                    "finish_time": "06:55",
                    "booking_date": "2017-05-25",
                    "cancelled": false,
                    "id": "222e766b-c873-445e-8e49-e060ae12492a",
                    "updated_at": "2017-05-14 13:52:35",
                    "created_at": "2017-05-14 13:52:35",
                    "clients": [
                        {
                            "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                            "username": "coreilly",
                            "email": "kaia.bayer@example.com",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                            "firstname": "Ludie",
                            "surname": "Pfannerstill",
                            "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                            "gender": "male",
                            "dob": "1989-03-11",
                            "mobile": "292.300.8518 x37716",
                            "landline": "+1 (506) 201-8955",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        },
                        {
                            "id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                            "username": "ernestine82",
                            "email": "chloe43@example.org",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?82996",
                            "firstname": "Kiara",
                            "surname": "Johnson",
                            "address": "63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512",
                            "gender": "male",
                            "dob": "1985-12-12",
                            "mobile": "331-762-7069 x74990",
                            "landline": "480.844.9263 x62498",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        }
                    ]
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add booking information.",
                "errors": {
                    "clients": [
                        "The clients field is required."
                    ],
                    "session_type_id": [
                        "The session type id field is required."
                    ],
                    "start_time": [
                        "The start time field is required."
                    ],
                    "end_time": [
                        "The end time field is required."
                    ]
                },
                "status_code": 422
            }

## Show Booking Details [GET /bookings/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "booking": {
                    "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                    "start_time": "05:05",
                    "finish_time": "06:55",
                    "booking_date": "2017-05-25",
                    "cancelled": false,
                    "id": "222e766b-c873-445e-8e49-e060ae12492a",
                    "updated_at": "2017-05-14 13:52:35",
                    "created_at": "2017-05-14 13:52:35",
                    "clients": [
                        {
                            "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                            "username": "coreilly",
                            "email": "kaia.bayer@example.com",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                            "firstname": "Ludie",
                            "surname": "Pfannerstill",
                            "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                            "gender": "male",
                            "dob": "1989-03-11",
                            "mobile": "292.300.8518 x37716",
                            "landline": "+1 (506) 201-8955",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        },
                        {
                            "id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                            "username": "ernestine82",
                            "email": "chloe43@example.org",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?82996",
                            "firstname": "Kiara",
                            "surname": "Johnson",
                            "address": "63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512",
                            "gender": "male",
                            "dob": "1985-12-12",
                            "mobile": "331-762-7069 x74990",
                            "landline": "480.844.9263 x62498",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        }
                    ]
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Update Booking [PUT /bookings/{id}]


+ Parameters
    + clients: (array, required) - Ids of client
    + session_type_id: (string, required) - 
    + booking_date: (date, required) - Format is Y-m-d
    + start_time: (string, required) - 
    + finish_time: (string, required) - 
    + cancelled: (boolean, optional) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "clients": [
                    "08dcf275-e2be-4e6a-a977-e722c59b7526",
                    "bf8b12ef-6352-44dd-afcd-3db8bef07678"
                ],
                "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                "start_time": "05:05",
                "finish_time": "06:55"
            }

+ Response 200 (application/json)
    + Body

            {
                "booking": {
                    "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                    "start_time": "05:05",
                    "finish_time": "06:55",
                    "booking_date": "2017-05-25",
                    "cancelled": false,
                    "id": "222e766b-c873-445e-8e49-e060ae12492a",
                    "updated_at": "2017-05-14 13:52:35",
                    "created_at": "2017-05-14 13:52:35",
                    "clients": [
                        {
                            "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                            "username": "coreilly",
                            "email": "kaia.bayer@example.com",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                            "firstname": "Ludie",
                            "surname": "Pfannerstill",
                            "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                            "gender": "male",
                            "dob": "1989-03-11",
                            "mobile": "292.300.8518 x37716",
                            "landline": "+1 (506) 201-8955",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        },
                        {
                            "id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                            "username": "ernestine82",
                            "email": "chloe43@example.org",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?82996",
                            "firstname": "Kiara",
                            "surname": "Johnson",
                            "address": "63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512",
                            "gender": "male",
                            "dob": "1985-12-12",
                            "mobile": "331-762-7069 x74990",
                            "landline": "480.844.9263 x62498",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        }
                    ]
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add booking information.",
                "errors": {
                    "clients": [
                        "The clients field is required."
                    ],
                    "session_type_id": [
                        "The session type id field is required."
                    ],
                    "start_time": [
                        "The start time field is required."
                    ],
                    "end_time": [
                        "The end time field is required."
                    ]
                },
                "status_code": 422
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Delete Booking [DELETE /bookings/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "booking": {
                    "session_type_id": "384f8c02-1702-4aec-9188-e1dc2487bc98",
                    "start_time": "05:05",
                    "finish_time": "06:55",
                    "booking_date": "2017-05-25",
                    "cancelled": false,
                    "id": "222e766b-c873-445e-8e49-e060ae12492a",
                    "updated_at": "2017-05-14 13:52:35",
                    "created_at": "2017-05-14 13:52:35",
                    "clients": [
                        {
                            "id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                            "username": "coreilly",
                            "email": "kaia.bayer@example.com",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?44392",
                            "firstname": "Ludie",
                            "surname": "Pfannerstill",
                            "address": "76920 Verner Underpass\nLake Jannieton, AZ 19549-3541",
                            "gender": "male",
                            "dob": "1989-03-11",
                            "mobile": "292.300.8518 x37716",
                            "landline": "+1 (506) 201-8955",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "08dcf275-e2be-4e6a-a977-e722c59b7526",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        },
                        {
                            "id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                            "username": "ernestine82",
                            "email": "chloe43@example.org",
                            "avatar": "http:\/\/lorempixel.com\/640\/480\/?82996",
                            "firstname": "Kiara",
                            "surname": "Johnson",
                            "address": "63820 Okuneva Mountain Apt. 080\nRaynortown, IN 42512",
                            "gender": "male",
                            "dob": "1985-12-12",
                            "mobile": "331-762-7069 x74990",
                            "landline": "480.844.9263 x62498",
                            "emergency_contact_name": null,
                            "emergency_contact_relationship": null,
                            "emergency_contact_number": null,
                            "contraindications": null,
                            "notes": null,
                            "created_at": "2017-05-12 10:43:44",
                            "pivot": {
                                "booking_id": "222e766b-c873-445e-8e49-e060ae12492a",
                                "client_id": "bf8b12ef-6352-44dd-afcd-3db8bef07678",
                                "paid": "0",
                                "created_at": "2017-05-14 13:52:35",
                                "updated_at": "2017-05-14 13:52:35"
                            }
                        }
                    ]
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Booking] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

# Payments [/payments]

## List of Payments [GET /payments]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 2,
                "per_page": 20,
                "current_page": 1,
                "last_page": 1,
                "next_page_url": null,
                "prev_page_url": null,
                "from": 1,
                "to": 2,
                "data": [
                    {
                        "id": "62ed8907-c898-468d-8416-90e92759503d",
                        "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                        "client_data": "Payment 2",
                        "description": null,
                        "amount": "50.00",
                        "payment_date": "2017-05-15 00:00:00",
                        "deleted_at": null,
                        "created_at": "2017-05-13 07:43:51",
                        "updated_at": "2017-05-13 07:43:51"
                    },
                    {
                        "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                        "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                        "client_data": "This is cover letter",
                        "description": null,
                        "amount": "50.00",
                        "payment_date": "2017-05-15 00:00:00",
                        "deleted_at": null,
                        "created_at": "2017-05-13 07:40:16",
                        "updated_at": "2017-05-13 07:40:16"
                    }
                ]
            }

## List of Payments of Client [GET /payments/client/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 2,
                "per_page": 20,
                "current_page": 1,
                "last_page": 1,
                "next_page_url": null,
                "prev_page_url": null,
                "from": 1,
                "to": 2,
                "data": [
                    {
                        "id": "62ed8907-c898-468d-8416-90e92759503d",
                        "client_id": "a1270b4d-b898-441b-b2c3-c431a021a186",
                        "client_data": "Payment 2",
                        "description": null,
                        "amount": "50.00",
                        "payment_date": "2017-05-15 00:00:00",
                        "deleted_at": null,
                        "created_at": "2017-05-13 07:43:51",
                        "updated_at": "2017-05-13 07:43:51"
                    },
                    {
                        "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                        "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                        "client_data": "This is cover letter",
                        "description": null,
                        "amount": "50.00",
                        "payment_date": "2017-05-15 00:00:00",
                        "deleted_at": null,
                        "created_at": "2017-05-13 07:40:16",
                        "updated_at": "2017-05-13 07:40:16"
                    }
                ]
            }

## Add Payment [POST /payments]


+ Parameters
    + client_id: (string, required) - 
    + client_data: (float, required) - 
    + payment_date: (date, required) - date format is Y-m-d
    + amount: (float, required) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                "client_data": "This is cover letter",
                "amount": 50,
                "payment_date": "2017-05-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "payment": {
                    "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                    "client_data": "This is cover letter",
                    "amount": 50,
                    "payment_date": "2017-05-15 00:00:00",
                    "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                    "updated_at": "2017-05-13 07:40:16",
                    "created_at": "2017-05-13 07:40:16"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add payment information.",
                "errors": {
                    "client_id": [
                        "The client id field is required."
                    ],
                    "client_data": [
                        "The client data field is required."
                    ],
                    "amount": [
                        "The amount field is required."
                    ],
                    "payment_date": [
                        "The payment date field is required."
                    ]
                },
                "status_code": 422
            }

## Show Payment Details [GET /payments]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "payment": {
                    "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                    "client_data": "This is cover letter",
                    "amount": 50,
                    "payment_date": "2017-05-15 00:00:00",
                    "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                    "updated_at": "2017-05-13 07:40:16",
                    "created_at": "2017-05-13 07:40:16"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Update Payment [PUT /payments/{id}]


+ Parameters
    + client_id: (string, required) - 
    + client_data: (float, required) - 
    + payment_date: (date, required) - date format is Y-m-d
    + amount: (float, required) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "client_data": "This is cover letter",
                "amount": 50,
                "payment_date": "2017-05-15"
            }

+ Response 200 (application/json)
    + Body

            {
                "payment": {
                    "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                    "client_data": "This is cover letter",
                    "amount": 50,
                    "payment_date": "2017-05-15 00:00:00",
                    "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                    "updated_at": "2017-05-13 07:40:16",
                    "created_at": "2017-05-13 07:40:16"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add payment information.",
                "errors": {
                    "client_id": [
                        "The client id field is required."
                    ],
                    "client_data": [
                        "The client data field is required."
                    ],
                    "amount": [
                        "The amount field is required."
                    ],
                    "payment_date": [
                        "The payment date field is required."
                    ]
                },
                "status_code": 422
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Delete Payment [DELETE /payments/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "payment": {
                    "client_id": "d6721c82-713e-4255-8781-80f6dd82b346",
                    "client_data": "This is cover letter",
                    "amount": 50,
                    "payment_date": "2017-05-15 00:00:00",
                    "id": "f25a568f-f12e-4b23-aad6-4d4cb3a4eedb",
                    "updated_at": "2017-05-13 07:40:16",
                    "created_at": "2017-05-13 07:40:16"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\Payment] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

# SessionTypes [/session_types]

## List of SessionTypes [GET /session_types]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "total": 10,
                "per_page": 1,
                "current_page": 1,
                "last_page": 10,
                "next_page_url": "http:\/\/localhost:8000\/api\/session-types?page=2",
                "prev_page_url": null,
                "from": 1,
                "to": 1,
                "data": [
                    {
                        "id": "0ae48790-92de-4576-bb42-dcd4c24b00c1",
                        "name": "Hester",
                        "duration": "50.89",
                        "duration_unit": "minute",
                        "price": "95.70",
                        "payable_per_duration": true,
                        "payable_per_person": true,
                        "deactivated": false,
                        "limited_to": "7",
                        "deleted_at": null,
                        "created_at": "2017-05-12 10:43:49",
                        "updated_at": "2017-05-12 10:43:49"
                    }
                ]
            }

## Add Session Type [POST /session_types]


+ Parameters
    + name: (string, required) - 
    + duration: (float, required) - 
    + duration_unit: (string, required) - 
    + price: (float, required) - 
    + payable_per_duration: (boolean, required) - 
    + payable_per_person: (boolean, required) - 
    + deactivated: (boolean, required) - 
    + limited_to: (integer, required) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "Hester",
                "duration": "50.89",
                "duration_unit": "minute",
                "price": "95.70",
                "payable_per_duration": true,
                "payable_per_person": true,
                "deactivated": false,
                "limited_to": "7"
            }

+ Response 200 (application/json)
    + Body

            {
                "session_type": {
                    "id": "0ae48790-92de-4576-bb42-dcd4c24b00c1",
                    "name": "Hester",
                    "duration": "50.89",
                    "duration_unit": "minute",
                    "price": "95.70",
                    "payable_per_duration": true,
                    "payable_per_person": true,
                    "deactivated": false,
                    "limited_to": "7",
                    "deleted_at": null,
                    "created_at": "2017-05-12 10:43:49",
                    "updated_at": "2017-05-12 10:43:49"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add session type information.",
                "errors": {
                    "name": [
                        "The name field is required."
                    ],
                    "duration": [
                        "The duration field is required."
                    ],
                    "duration_unit": [
                        "The duration unit field is required."
                    ],
                    "price": [
                        "The price field is required."
                    ],
                    "payable_per_duration": [
                        "The payable per duration field is required."
                    ],
                    "payable_per_person": [
                        "The payable per person field is required."
                    ],
                    "deactivated": [
                        "The deactivated field is required."
                    ],
                    "limited_to": [
                        "The limited to field is required."
                    ]
                },
                "status_code": 422
            }

## Show Session Type [GET /session_types/{id}]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "session_type": {
                    "id": "0ae48790-92de-4576-bb42-dcd4c24b00c1",
                    "name": "Hester",
                    "duration": "50.89",
                    "duration_unit": "minute",
                    "price": "95.70",
                    "payable_per_duration": true,
                    "payable_per_person": true,
                    "deactivated": false,
                    "limited_to": "7",
                    "deleted_at": null,
                    "created_at": "2017-05-12 10:43:49",
                    "updated_at": "2017-05-12 10:43:49"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Add Session Type [PUT /session_types/{id}]


+ Parameters
    + name: (string, required) - 
    + duration: (float, required) - 
    + duration_unit: (string, required) - 
    + price: (float, required) - 
    + payable_per_duration: (boolean, required) - 
    + payable_per_person: (boolean, required) - 
    + deactivated: (boolean, required) - 
    + limited_to: (integer, required) - 

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "Hester",
                "duration": "50.89",
                "duration_unit": "minute",
                "price": "95.70",
                "payable_per_duration": true,
                "payable_per_person": true,
                "deactivated": false,
                "limited_to": "7"
            }

+ Response 200 (application/json)
    + Body

            {
                "session_type": {
                    "id": "0ae48790-92de-4576-bb42-dcd4c24b00c1",
                    "name": "Hester",
                    "duration": "50.89",
                    "duration_unit": "minute",
                    "price": "95.70",
                    "payable_per_duration": true,
                    "payable_per_person": true,
                    "deactivated": false,
                    "limited_to": "7",
                    "deleted_at": null,
                    "created_at": "2017-05-12 10:43:49",
                    "updated_at": "2017-05-12 10:43:49"
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Could not add session type information.",
                "errors": {
                    "name": [
                        "The name field is required."
                    ],
                    "duration": [
                        "The duration field is required."
                    ],
                    "duration_unit": [
                        "The duration unit field is required."
                    ],
                    "price": [
                        "The price field is required."
                    ],
                    "payable_per_duration": [
                        "The payable per duration field is required."
                    ],
                    "payable_per_person": [
                        "The payable per person field is required."
                    ],
                    "deactivated": [
                        "The deactivated field is required."
                    ],
                    "limited_to": [
                        "The limited to field is required."
                    ]
                },
                "status_code": 422
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }

## Delete Session Type [DELETE /session_types/{id}]


+ Response 200 (application/json)
    + Body

            {
                "session_type": {
                    "id": "0ae48790-92de-4576-bb42-dcd4c24b00c1",
                    "name": "Hester",
                    "duration": "50.89",
                    "duration_unit": "minute",
                    "price": "95.70",
                    "payable_per_duration": true,
                    "payable_per_person": true,
                    "deactivated": false,
                    "limited_to": "7",
                    "deleted_at": null,
                    "created_at": "2017-05-12 10:43:49",
                    "updated_at": "2017-05-12 10:43:49"
                }
            }

+ Response 500 (application/json)
    + Body

            {
                "message": "No query results for model [App\\Models\\SessionType] 0b2db6ac-e596-4981-b39a-2cbfafc996ea1",
                "status_code": 500
            }