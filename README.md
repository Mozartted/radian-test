# GreenIT Application Challenge

This project is the seed files needed to create a GreenIT test application.

Objective: This test will be a fully functional web application that will display the given data from a csv file, and allow full editing capabilties of the data.

## Application Version Requirements

1. Frontend must be in Anguar 10+
2. Backend must be in PHP 7.2+
3. You may include any npm modules needed.
4. Frontend should be built using npm, backend should be raw php files.

## Backend Requirements

1. The backend will provide data to the frontend through a RESTful API
2. The API will allow GET requests for getting all records.
3. The API will allow POST requests for save, update, and delete.  
   (The implementation for these can be mocked. You do not have to write to the data file.)
4. The API response will be JSON formatted data.
5. The data will be read from a provided data file.

## Frontend Requirements

1. Data will be displayed in a table view.
2. Each column header in the table will correspond to a field name in the data file.
3. Allow each row and field to be edited.
4. Allow record creation and deletion, either inline or modal.

## Data

1. Data will be provided as csv text file.
2. The fist row of the data file will contain the field names.

## Tests

1. Any testing framework/runner will be allowed with explicit instructions. If you are looking for one to use, we use Codeception.
2. Any type of tests, Unit, Functional, Acceptance, or API tests.
3. The more test case coverage the better.

## Extras

1. Implement a immutable state solution in front end (e.g. Redux, ngrx, Akita)
2. Show different parent child communication styles within your application.
3. Show or describe web server architecture used.
4. Extra points for making an easy comand line install or a Dockerfile to build the application
5. Make the API fully functional, and write to the CSV file.

---

# My Solution.
The frontend was developed with Angular 15, and the backend is build on php, without any framework design. The libraries employed were used to create a light-weight framework design for better code management. So this architecture is build just for the sole purpose of this project.

### Advantages

This allows us to use proper cors architecture and design a proper routing system for your api calls.

### The backend libraries.

- PHP-DI: this allows us to use dependency injection within our architecture and evolve a singleton pattern with respect to Class dependency management.
- FastRoute: This help us maintain a routing structure with a dispatch system combining with our Dependency injection pattern.
- SapiEmitter : This library allows us to emit our responses via the strategic use of PSR-15 php request response architecture.
- League/CSV: a library for managing and writing to CSV files.

## Running the project

### Docker setup
WIP(work in process)

### Running with Command line.

- Run dependency installation commands on both the backend and frontends respectively

```sh
# in the frontend folder
$ npm install
```

```sh
# in the backend folder (ensure you have composer setup)
$ composer install
```

- Access the frontend folder in your terminal, run the command

```sh
$ npm start
```

- Access the backend folder in your terminal

```sh
$ php -S localhost:4000 -t public/
```

- Your app should be running. Access the angular app on http://localhost:4200, check in on the CSV file at backend/data.csv
