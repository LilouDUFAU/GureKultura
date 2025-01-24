EN | [FR](README.md)

# GureKultura

A web application for event management centered around the Basque Country.

# Table of Contents

- [About](#about)
- [Download](#download)
- [Setup](#Setup)
- [Project Structure](#project-structure)
- [Installing Wamp](#installing-wamp)

# About

GureKultura is a student project developed during an SAE (Learning and Assessment Situation). It is an application designed to manage events throughout the Basque Country. The goal of the application is to promote Basque culture and highlight activities that students or young professionals working in the Southwest of France shouldn’t miss.  
In addition to creating their own events, users can sign up for activities they are interested in.

# Download

Download or clone the repository on your machine. Then open the `php/index.php` file in your browser.  
For more detailed installation instructions, refer to the [installation](#installation) section.

# Setup

This application requires a database to function. At the moment, we do not have a hosted database.

- Download GureKultura
    - If you’re working on Citrix, install the project on your Lakartxela.
    - If you’re working on your own machine, install the project using a hosting solution. We recommend using [Wamp](https://www.wampserver.com/#wampserver-64-bits-php-5-6-25-php-7) for this. For detailed help on installing the project on _Wamp_, check the [Installing Wamp](#installing-wamp) section.

-> In a terminal:

- Clone the repository
```sh
git clone https://github.com/LilouDUFAU/GureKultura 
cd GureKultura
```

- Install dependencies
```sh
npm install 
composer install
```

- Configure the application  
    Open the `config` folder and create a file called `constantes.yaml`. Then, follow the model provided in `modeleConstanteYml.md` to fill in this file.

**!! Ensure the database-related lines match your configuration !!**

# Project Structure

- **app/controllers**: Contains the application's controllers to handle requests.
- **app/models**: Contains class models to manage database interactions.
- **asset**: Contains static assets such as images or icons.
- **config**: Contains configuration files.
- **css**: Contains the CSS stylesheets for the application.
- **docs**: Contains all project documentation for the classes.
- **js**: Contains all necessary JavaScript scripts.
- **templates**: Contains templates rendered as HTML views.
- **vendor**: Contains third-party libraries and dependencies.

# Installing Wamp

- Download [Wamp](https://www.wampserver.com/#wampserver-64-bits-php-5-6-25-php-7).
- Launch Wamp; it should take 1-2 minutes to start.
- Go to [localhost](http://localhost/).
- Click on `Add a VirtualHost`.
- Fill in the project-related information, e.g.:
    - Project name: gurekultura.
    - Specify the project path, which should be inside the `wamp64/www` folder.
    - Check the `Use PHP in FCGI mode` box and select `PHP: 8.1.31`.
- Restart Wamp to complete the VirtualHost configuration.