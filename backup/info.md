# Instructions

## Documentation on how react is integrated in laravel
generate api using laravel
https://code.tutsplus.com/tutorials/build-a-react-app-with-laravel-restful-backend-part-1-laravel-5-api--cms-29442

integrate those laravel json api using react
https://code.tutsplus.com/tutorials/build-a-react-app-with-laravel-backend-part-2-react--cms-29443

## Documentation on using React Router
https://reacttraining.com/react-router/web/guides/quick-start

## Setup Instructions
```
git clone ...
cd DHIS
```

create database and import database
```
mysqladmin -u root -p create dhis
mysql -u root -p dhis < backup/dhis.sql
```
if these commands didn't work, use localhost/phpmyadmin
and again if the database is not imported successfully - ask pradeep or ruju for assistance

install required vendors and generate key
```
composer install
npm install
```

## .env file
create a copy of .env.example to .env and modify following lines:
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

## Running Server
```
php artisan key:generate
php artisan serve
npm run watch
```
Now visit localhost:8000/main/ for react (currently developers are also working in localhost:8000/ so, do not change the site_url from /main/ to / in Main.js and in routes/web.php, unless you can confidently built the site in react)

## React Router Dom
If localhost:8000/main doesn't show anything then,
`npm install react-router-dom --save` and `npm run watch` might fix the issue.

## Frontend - React
Now, navigate to Outputs, Outcomes links: you may notice the url link is changing while clicking to these links. And when you reload the page, after visiting Outputs, Outcomes - all of a sudden you may see 404 page. It's because there is no, route of localhost:8000/main/outputs and localhost:8000/main/outcomes in routes/web.php

So we can re-direct the user to localhost:8000/main/ page when s/he reloads the page. Or we can later research about this.

Working files: 
```
resources/assets/js/app.js
resources/assets/js/components/Main.js (also see which files are being imported)

resources/assets/sass/app.scss

resources/views/welcome-react.blade.php (while backend developers will keep working on welcome.blade.php)

routes/web.php
```

### Sample React Component
Build components not the templates. So, a sample components structure below comes handy a lot of times:
```js
//resources/assets/js/components/templates/Dashboard/index.js
import React, { Component } from 'react';

class Dashboard extends Component {
	render() {
		return(
			<div className="row">
				<div className="col-md-9">
					<p>Our goal is to reduce malnutrition and improve nutritional status of  the peoples of Bangladesh with special emphasis to the children, adolescents, pregnant & lactating women, elderly, poor and underserved population of both rural and urban area in line with National Nutrition Policy 2015.</p>
				</div>

				<div className="col-md-3">
					<div className="aside">
						<h2>Inputs</h2>
					</div>
				</div>
			</div>
		);
	}
}

export default Dashboard;
```

## What's Next
Now, build some small-small components that can be reused later to build an awesome site. 
