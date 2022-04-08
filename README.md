# Test

## Installation

```console
git clone git@github.com:matiaspiuma/sesame-laravel.git
cd sesame-laravel
docker-compose up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan tests
```

## Endpoints

### [GET] /api/v1/employees

Response

````json
{
  [
    "data": {
      "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
      "name": "John Doe",
      "email": "johndoe@example.test",
      "created_at": "2022-04-08 10:15:00",
      "updated_at": "2022-04-08 10:15:00",
    }
  ]
}
````

### [POST] /api/v1/employees

body:
```json
{
  "name": "John Doe",
  "email": "johndoe@example.test",
}
```

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "name": "John Doe",
    "email": "johndoe@example.test",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [GET] /api/v1/employees/{employeeId}

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "name": "John Doe",
    "email": "johndoe@example.test",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [PUT] /api/v1/employees/{employeeId}

body:
```json
{
  "name": "John Doe",
  "email": "johndoe@example.test",
}
```

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "name": "John Doe",
    "email": "johndoe@example.test",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [DELETE] /api/v1/employees/{employeeId}

response

```json
```

### [GET] /api/v1/employees/{employeeId}/workentries

response

```json
{
  [
    "data": {
      "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
      "employee_id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
      "start_date": "2022-04-08 10:15:00",
      "end_date": "2022-04-08 11:15:00",
      "created_at": "2022-04-08 10:15:00",
      "updated_at": "2022-04-08 10:15:00",
    }
  ]
}
```

### [POST] /api/v1/employees/{employeeId}/workentries

body:
```json
{
  "start_date": "2022-04-08 10:15:00",
  "end_date": "2022-04-08 11:15:00",
}
```

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "employee_id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "start_date": "2022-04-08 10:15:00",
    "end_date": "2022-04-08 11:15:00",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [GET] /api/v1/employees/{employeeId}/workentries/{workEntryId}

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "employee_id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "start_date": "2022-04-08 10:15:00",
    "end_date": "2022-04-08 11:15:00",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [PUT] /api/v1/employees/{employeeId}/workentries/{workEntryId}

body:

```json
{
  "start_date": "2022-04-08 10:15:00",
  "end_date": "2022-04-08 11:15:00",
}
```

response

```json
{
  "data": {
    "id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "employee_id": "f281fd8c-5948-404a-9470-dfb6dd4dcf0f",
    "start_date": "2022-04-08 10:15:00",
    "end_date": "2022-04-08 11:15:00",
    "created_at": "2022-04-08 10:15:00",
    "updated_at": "2022-04-08 10:15:00",
  }
}
```

### [DELETE] /api/v1/employees/{employeeId}/workentries/{workEntryId}

body:

```json
```