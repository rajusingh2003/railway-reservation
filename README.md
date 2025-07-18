#  Railway Reservation System (PHP + MySQL)

A full-stack web application for booking train tickets, checking PNR status, and managing basic admin operations. Developed using PHP, MySQL, HTML, CSS, and JavaScript.

## 🔧 Features

-  User Registration & Login
-  Book Tickets by Train ID and Seats
-  Check PNR Status
-  Admin panel (add/view trains & bookings)
-  Secure password storage with PHP `password_hash()`

##  Tech Stack

- Frontend:** HTML, CSS, JavaScript
- Backend:** PHP (Core PHP, no framework)
- Database:** MySQL
- Server:** XAMPP (Apache, MySQL)
- Auth:** Sessions, password_hash()

 ⚙️Database Schema

- `users (id, name, email, password)`
- `trains (id, name, from_station, to_station, total_seats)`
- `bookings (id, user_id, train_id, seats_booked, pnr, date)`

##  Folder Structure

