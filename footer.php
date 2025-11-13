<style>
    footer {
        background: #0f172a;
        color: #e2e8f0;
        padding: 60px 0 20px;
    }

    footer h5 {
        font-weight: 600;
        color: #fff;
        margin-bottom: 20px;
        position: relative;
    }

    footer h5::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 50px;
        height: 2px;
        background: #3b82f6;
    }

    footer a {
        color: #cbd5e1;
        text-decoration: none;
        display: block;
        margin-bottom: 10px;
        transition: color 0.3s;
    }

    footer a:hover {
        color: #3b82f6;
    }

    .footer-social-icons a {
        display: inline-block;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1e293b;
        color: #e2e8f0;
        text-align: center !important;
        line-height: 38px;
        transition: all 0.3s;
    }

    .footer-social-icons a:hover {
        background: #3b82f6;
        color: #fff;
        transform: translateY(-3px);
    }

    .footer-bottom {
        border-top: 1px solid #334155;
        text-align: center;
        padding-top: 20px;
        color: #94a3b8;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        footer {
            text-align: center;
        }

        footer h5::after {
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<!-- ====== Footer Section ====== -->
<footer>
    <div class="container text-start">
        <div class="row gy-4">
            <!-- About -->
            <div class="col-md-3">
                <h5>About Us</h5>
                <p>
                    We are a passionate team dedicated to creating beautiful web solutions
                    with clean design and powerful functionality.
                </p>
                <div class="footer-social-icons mt-3">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3">
                <h5>Quick Links</h5>
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Blogs</a>
                <a href="#">Contact</a>
            </div>

            <!-- Services -->
            <div class="col-md-3">
                <h5>Our Services</h5>
                <a href="#">Web Development</a>
                <a href="#">UI/UX Design</a>
                <a href="#">Digital Marketing</a>
                <a href="#">SEO Optimization</a>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3">
                <h5>Contact Us</h5>
                <p><i class="bi bi-geo-alt-fill me-2"></i> Panthapath, Dhaka, Bangladesh</p>
                <p><i class="bi bi-envelope-fill me-2"></i> sumonpro.dev@gmail.com</p>
                <p><i class="bi bi-telephone-fill me-2"></i> +880 1402 042826</p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom mt-4">
            © 2025 <strong>My Web Application</strong>. All rights reserved. | Designed by <span style="color:#3b82f6;">Sumon Prodhan</span>
        </div>
    </div>
</footer>