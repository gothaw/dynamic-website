# dynamic-website

Dynamic website design created in PHP using model-view-controller architectural pattern. The aim of the project was to built an MVC website using PHP without any frameworks, ORM tools or templating engines. The whole project has been built from scratch using an HTML template and was a practice exercise to learn OOP PHP, SQL and principles of MVC. 

### Website Structure

The app serves as website of a gym and fitness centre. It includes:

**Home** - home page, with short about us section, client opinions and featured gym classes

**Blog** - blog page with dynamically generated blog posts, side bar with posts categories and tags, clicking on these displays relevant posts based on tag/category selected

**About** - about page with classes types that are run in the gym and team members

**Schedule** - upcoming classes schedule, logged in users are allowed to sign up to a class

**Contact** - contact page with a map, contact form and address details

**Dashboard** - user account page with account summary and possibility to buy membership via PayPal, change personal details and change password

**Admin Panel** - admin panel section that allows for editing classes, coaches, gym members details and upcoming classes. Also allows for adding new blog posts and moderating comments

### MVC Pattern

The MVC definition as found on the web (source: [TutorialsTeacher](https://www.tutorialsteacher.com/mvc/mvc-architecture)):

**Model:** Model represents shape of the data and business logic. It maintains the data of the application. Model objects retrieve and store model state in a database.

**View:** View is a user interface. View displays data using model to the user and also enables them to modify the data.

**Controller:** Controller handles the user requests. User interact with View, which in-turn raises appropriate URL request, this request will be handled by a controller. The Controller renders the appropriate View with the model data as a response.

 ![mvc-pattern](https://www.tutorialsteacher.com/Content/images/mvc/mvc-architecture.png)
 
 *MVC Pattern* (source: [TutorialsTeacher](https://www.tutorialsteacher.com/mvc/mvc-architecture))

### Built With

HTML5, CSS5, JavaScript, PHP

##### Libraries: 

[jQuery](https://jquery.com), [jQuery Nice Select](https://hernansartorio.com/jquery-nice-select/), [Owl Carousel](https://owlcarousel2.github.io/OwlCarousel2/), [Animate.css](https://daneden.github.io/animate.css/)

#### Frameworks:

[Bootstrap](https://getbootstrap.com) 

### Deployment

App configuration is handled by config.php file. In order to deploy the app:
 
 - Change *EMAIL_TO* and *ROOT* constants to production values
 - Fill in database info and reCAPTCHA API keys in *$GLOBALS* variable.
 - Switch error handling to production
 - Set the time zone
 
Additionally, change the rewrite base in .htaccess file in the main project folder to production value. 

### Authors

Radoslaw Soltan

### License

This project is under the MIT License - see the LICENSE.md file for details.

### Acknowledgment 

The website is based on [Fitzone](https://colorlib.com/wp/template/fitzone/) HTML template created by [Colorlib](https://colorlib.com/). It is not for commercial use and I do not own any of the assets shown on the website. Some of the styling, scripting and markup were altered to fit the purpose of the project.

Images not included in the template assets are free and open source and were taken from:

* https://www.pexels.com
* https://pixabay.com
* https://www.flaticon.com 

Website uses reCAPTCHA v3 to protect against spam and bots.


### Disclaimer

Newsletter functionality has not been implemented, it is recommended using some third party API such as [Mailgun](https://www.mailgun.com).