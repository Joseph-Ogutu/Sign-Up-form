This sign up form allows the user to first sign up then sign in.
The form has the following working features;
1.The show password Feature.
2.Password Strength checker.
3.The confirm input, in that when the user types his/her password to the password input, the confirm password input is automatically typed with the exact details typed in the password input.
through this we save time.
4.Forgot password link.when the forgot password is clicked, the JS code sends AJAX request to the forget-password.php script with the email address as a parameter.
The PHP sript then handle the password reset logic and returns a success message or error message to the JavaScript code.
Here is the step of reseting password👇
Forget Password 👉 Enter email and sent a resent link 👉 Reset your Password.
THE PASSWORD RESET LOGIC PROCESS👇
1.Verifying user identity- ask user to enter email address to verify against our database.
2.Generate Password Reset Token.
3.Store password Reset Token- stores the password reset token in the database along with the user email.
4.Send password Reset Email - send user password reset link via email.
5.User set the new password and send to the db.
6.Invalidating the upassword reset token to prevent reuse.
Besides I have used password Hashing algorithm to hassh users password this prevent from attacks in any case of access to the database.



Download the zip file and extract.
Run xamp control panel and create a database called login.
create a table with this code👇👇
CREATE TABLE login (
  id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  email VARCHAR (100) UNIQUE,
  password VARCHAR(255),
  PRIMARY KEY (id)
);

then run your project.
Finally I have used a lot of comments to explain the code.Thanks

