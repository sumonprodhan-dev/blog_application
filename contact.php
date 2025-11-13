<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us | Blog Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .contact-section {
            padding: 80px 0;
        }

        .contact-heading h2 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 10px;
        }

        .contact-heading p {
            color: #6c757d;
            font-size: 1rem;
        }

        .contact-info {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 40px;
            height: 100%;
        }

        .info-box {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #007bff, #00b4d8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 22px;
        }

        .info-text h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-text p {
            color: #6c757d;
            margin: 0;
        }

        .contact-form {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px 15px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        .btn-submit {
            background: linear-gradient(135deg, #007bff, #00b4d8);
            border: none;
            color: #fff;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #0056b3, #0096c7);
            transform: translateY(-2px);
        }

        iframe {
            width: 100%;
            height: 320px;
            border-radius: 12px;
            border: none;
            margin-top: 20px;
        }

        @media (max-width: 992px) {
            .contact-info {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <?php include 'navbar.php'; ?>
    </div>
    <section class="contact-section">
        <div class="container">
            <div class="text-center contact-heading mb-5">
                <h2>Contact Us</h2>
                <p>We’re here to help and answer any questions you might have.</p>
            </div>

            <div class="row g-5 align-items-start">
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="contact-info">
                        <div class="info-box">
                            <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div class="info-text">
                                <h5>Our Office</h5>
                                <p> Dhaka, Bangladesh</p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                            <div class="info-text">
                                <h5>Email Us</h5>
                                <p>sumonpro.dev@gmail.com</p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                            <div class="info-text">
                                <h5>Call Us</h5>
                                <p>+880 14020 42826</p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                            <div class="info-text">
                                <h5>Working days</h5>
                                <p>24/7</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="contact-form">
                        <form action="send_message.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                                </div>
                                <div class="col-12">
                                    <textarea name="message" class="form-control" rows="5" placeholder="Write your message..." required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn-submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <iframe
                class="mt-5"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9025326797134!2d90.39122931543103!3d23.750885394610897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8af5111f4a1%3A0xe7df7e9a7b5a37cf!2sDhaka!5e0!3m2!1sen!2sbd!4v1697040953443!5m2!1sen!2sbd"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </section>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>