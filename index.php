<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sphere Base</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav>
        <div class="text-xl font-semibold">Sphere Base</div>
        <div class="flex space-x-4">
            <a href="#about">About Us</a>
            <a href="#assortment">Assortment</a>
            <a href="#future">Future</a>
            <a href="#contacts">Contacts</a>
        </div>
        <div class="ml-4">
            <a href="cart.php">🛒</a>
        </div>
    </nav>
</header>

<main>
    <section id="about" class="my-4">
        <h2 class="text-2xl font-semibold mb-2">About Us</h2>
        <p class="text-gray-700">Information about Sphere Base</p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam consectetur et excepturi, fugiat harum id inventore nam nemo repellendus reprehenderit similique suscipit tempore velit veniam voluptatibus? Dignissimos enim labore repellat?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto commodi consequuntur distinctio, doloribus et, fugit inventore nemo officia omnis praesentium quasi qui repellendus reprehenderit sunt unde vitae voluptates voluptatum.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias ea, enim eos est harum ipsa molestiae necessitatibus nemo nobis odit pariatur placeat quaerat repellendus saepe sed unde vel veritatis!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus accusantium, aliquam explicabo in minus natus provident, quam repellendus repudiandae ullam ut vero? Dolores ea ipsam mollitia nemo repellat vero, voluptate.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi beatae consequatur culpa cum deleniti distinctio dolorem eligendi id laborum minus nostrum placeat quis quisquam rem, similique totam vel velit veniam.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias aliquam debitis, dicta dignissimos, dolorum, fuga harum ipsa labore libero necessitatibus nostrum quas quidem quod quos rerum sapiente ullam voluptatum?
    </section>

    <!-- Načítání produktů pomocí logiky "load_products.php" -->
    <section id="assortment" class="my-4">
        <h2 class="text-2xl font-semibold mb-2">Assortment</h2>
        <div class="grid-container">
            <?php include 'load_products.php'; ?>
        </div>
    </section>

    <section id="future" class="my-4">
        <h2 class="text-2xl font-semibold mb-2">Future</h2>
        <p class="text-gray-700">Our plans for the future</p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aperiam autem deserunt, eius eum facilis, illum iste maxime minima mollitia nobis, nostrum perferendis quas quibusdam quod sapiente sequi veniam vero!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum ea fugiat itaque mollitia officiis pariatur repellat soluta, temporibus velit voluptatum! Alias blanditiis dignissimos doloremque ex, explicabo laudantium quidem quis voluptas?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aperiam dolorem doloribus et, excepturi illo incidunt iusto laborum libero magni natus placeat repudiandae rerum similique suscipit, tenetur voluptates! Labore, sit.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias amet autem debitis, delectus eligendi eos in inventore iure laborum minima minus nemo nisi, provident totam ullam voluptas voluptatem voluptatibus.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto beatae dicta dolore dolorem dolorum, error expedita facere id iusto laudantium maiores minus porro quidem repellat, rerum sequi, sit ullam velit.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium commodi dolores ea exercitationem expedita facere iusto magnam, molestiae, obcaecati odit officia perferendis rem sequi. Aspernatur atque aut iure nihil sunt!
    </section>

    <section id="contacts" class="my-4">
        <h2 class="text-2xl font-semibold mb-2">Contacts</h2>
        <div class="grid-container">
            <div class="grid-cell">
                <h3>Contact Information</h3>
                <p>Sphere Base Inc.</p>
                <p>Biznisová ulice 69</p>
                <p>Telefon: XXX-XXX-XXX</p>
                <p>Email: contact@spherebase.com</p>
            </div>
            <div class="grid-cell">
                <h3>Map Location</h3>
                <div class="map-placeholder" style="width:100%;height:200px;background-color:#e2e8f0;text-align:center;line-height:200px;">Map Placeholder</div>
            </div>
            <div class="grid-cell">
                <h3>Feedback</h3>
                <form id="contact-form">
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                    <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    //Skript pro pohyb navbaru po stránce
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                let target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    let navbarHeight = document.querySelector('header').offsetHeight;
                    let position = target.offsetTop - navbarHeight;

                    window.scrollTo({
                        top: position,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
</body>
</html>
