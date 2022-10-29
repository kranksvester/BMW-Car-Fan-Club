<?php
  print'
      <h1>Contact Form</h1>
      <div id="contact">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2781.3818143615326!2d15.9366931!3d45.8036112!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2shr!4v1666549882835!5m2!1sen!2shr"
          width="100%"
          height="450"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
        <form
          action="send-form.php"
          id="contact_form"
          name="contact_form"
          method="POST"
        >
          <label for="fname">First Name:</label>
          <input
            type="text"
            id="fname"
            name="firstname"
            placeholder="Your first name..."
            required
          />

          <label for="lname">Last Name:</label>
          <input
            type="text"
            id="lname"
            name="lastname"
            placeholder="Your last name..."
            required
          />

          <label for="lname">Your E-mail:</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Your e-mail..."
            required
          />

          <label for="subject">Subject</label>
          <textarea
            id="subject"
            name="subject"
            placeholder="Write something..."
            style="height: 200px"
          ></textarea>

          <input type="submit" value="Submit" />
        </form>
      </div>';
?>
