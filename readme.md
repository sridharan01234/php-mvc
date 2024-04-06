# Application README

## Overview

This application provides a PHP-based login and registration system following the Model-View-Controller (MVC) architecture. It distinguishes between admin and regular users, offering different functionalities and access levels. Admin users have the authority to block and unblock other users, while regular users can edit their personal information.

## Features

1. **Login Page:** Users are required to log in with their credentials. Based on their role (admin or regular user), they are redirected to the appropriate dashboard.

2. **Registration Page:** New users can register by providing necessary details such as username, email, and password.

3. **Admin Dashboard:**
   - Admin users have access to a dashboard where they can view a list of users.
   - They can block or unblock users, thus controlling their access to the application.

4. **User Dashboard:**
   - Regular users can view and edit their personal information.
   - Their access is limited compared to admins.

## MVC Structure

1. **Model:** Contains the business logic and interacts with the database. It handles user authentication, registration, and user management functionalities.

2. **View:** Displays the user interface elements to the user. It includes HTML templates for login, registration, admin dashboard, and user dashboard.

3. **Controller:** Acts as an intermediary between the Model and View. It receives user input, processes it, and interacts with the Model to fetch data and update the View accordingly. It manages redirection based on user roles.


## Technologies Used

- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Security Considerations

- Implement proper validation and sanitization of user inputs to prevent SQL injection and XSS attacks.
- Store user passwords securely using hashing algorithms (e.g., bcrypt).
- Implement session management to handle user authentication securely.
- Apply access control measures to ensure that only authorized users can access specific functionalities.

## Future Enhancements

- Implement password recovery functionality.
- Enhance the user interface for better user experience.
- Implement role-based access control for more granular permissions.
- Add email verification for user registration.
- Implement two-factor authentication for enhanced security.

## Contributors

- [Sridharan]

## Support

For any issues or inquiries, please contact [sridharan01234@gmail.com].


bpwjtdqrhqialbow