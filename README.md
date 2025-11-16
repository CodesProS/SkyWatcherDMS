# SkyWatcher – Weather Management System

SkyWatcher is a web-based weather management platform that provides detailed real-time and historical weather data for cities around the world. It helps users analyse temperature, humidity, wind speed, visibility, cloudiness, and atmospheric pressure for any chosen city and date, with a clean, user-friendly interface. :contentReference[oaicite:0]{index=0}  

## Features

- **Detailed Weather Metrics**
  - Temperature (°C)  
  - Humidity (%)  
  - Wind speed (m/s)  
  - Visibility (km)  
  - Cloudiness (%)  
  - Atmospheric pressure (hPa) 

- **City & Date-Based Queries**
  - Select any city (worldwide) and view weather data for a specific date and, if needed, a specific time.  
  - Useful for daily planning, trip preparation, or climate pattern study.

- **Interactive Visualizations**
  - Bar graph showing average values of multiple weather metrics for selected dates.  
  - Line graph showing how a specific weather variable changes over time. 

- **Role-Based Access Control**
  - **Admin**
    - View full/raw datasets  
    - Insert, update, delete weather records  
    - Create and manage alerts for cities  
    - Assign or revoke admin privileges for other accounts  
  - **User**
    - View summarized, safe weather information with restricted operations (data abstraction). 

- **Weather Alerts for Admins**
  - Admins can configure alerts to detect hazardous conditions early (e.g., extreme storms, sudden drops in pressure).  
  - Useful for safety planning and proactive response.   

- **Secure, Modern UI**
  - Login / signup system with an animated, cloud-themed landing page.  
  - Responsive layout and smooth animations for a better user experience. 
## Tech Stack

- **Frontend**
  - HTML  
  - CSS (custom styling + animations)  
  - JavaScript  
  - [Chart.js](https://www.chartjs.org/) for graphs (bar & line charts)  

- **Backend**
  - PHP  
  - AJAX for async requests (form submission without page reload) 

- **Database**
  - MySQL (via XAMPP’s MySQL server) 

- **Environment**
  - XAMPP (Apache + MySQL + PHP) for local development and hosting. 

## Database Design

SkyWatcher uses a relational schema designed for clean weather and account management. Key tables include: 
- **Country**
  - Stores countries with coordinates.  

- **City**
  - Stores cities, linked to `Country`.  

- **Conditions**
  - Describes high-level condition types (e.g., Clear, Cloudy, Drizzle, Thunder, Snow) with summaries. 

- **WeatherDetails**
  - Stores numeric weather metrics (temperature, humidity, wind, cloudiness, visibility), linked to `Conditions`.  

- **Forecasts**
  - Contains dated forecasts: `FDate`, `CTime`, links to `WeatherDetails` and `City`.  

- **Alerts**
  - Stores city-specific alert types and descriptions, linked to `City`.  

- **Account**
  - Stores user credentials and profile info, plus `IsAdmin` flag for role-based access.  

*(Full SQL statements are in the project’s SQL/script files.)* 


