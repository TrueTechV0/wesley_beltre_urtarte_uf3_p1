<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <!-- Link to Bulma CSS CDN -->
  
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #eaeaea;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            text-align: center;
            background-color: #1a1a1a;
            color: white;
            padding: 20px 0;
        }

        header img {
            max-width: 100%;
            height: auto;
        }

        main {
            margin: 20px;
        }

        section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #333;
        }

        footer {
            background-color: grey;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        footer h3 {
            color: #ffc107;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            display: inline-block;
            margin-right: 15px;
        }

        footer a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid p-0">
            <img src="https://img.freepik.com/free-vector/cinema-realistic-poster-with-illuminated-bucket-popcorn-drink-3d-glasses-reel-tickets-blue-background-with-tapes-vector-illustration_1284-77070.jpg"
                class="img-fluid" alt="Header">
        </div>
    </header>

    <main>
        <section>
            @yield('content')
        </section>
    </main>

   <footer class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-half">
                <h3>Contact</h3>
                <p>Email: wesles0631@gmail.com</p>
                <p>Phone: +34 123 45 67 89</p>
            </div>
            <div class="column is-half">
                <h3>Follow us</h3>
                <ul>
                    <li><a href="#" class="has-text-light">Facebook</a></li>
                    <li><a href="#" class="has-text-light">Twitter</a></li>
                    <li><a href="#" class="has-text-light">Instagram</a></li>
                </ul>
            </div>
        </div>
        <div class="columns mt-3    ">
            <div class="column">
                <p class="mb-0">&copy; 2023 Cinema</p>
                <p class="mb-0">Discover new stories on the big screen!</p>
            </div>
        </div>
    </div>
</footer>

</body>

</html>
