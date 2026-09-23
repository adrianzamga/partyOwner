<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./Styles/index.css">
    <title>Party Owner</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.0/css/all.css">
</head>
<body>
    <nav class='nav-bar'>
        <a href="./index.php">
            <div class='logo'> 
                <img src="./assets/icons8-meeting.svg" alt="logo"class='logo'>
                <p>Party Owner</p>
            </div>
        </a>
        
        <div class='nav-btn'>
            <button onclick='window.location="./iniciar_sesion.php";' class='btn1'>Iniciar sesion</button>
            <button onclick='window.location="./crear_cuenta.php";' class='btn2'>Crear cuenta</button>
        </div>
    </nav>
    <main>
        <div class='container'>        
        <h1>Party Owner</h1>
        <p>Party Owner es una plataforma que te permite organizar fiestas y eventos de manera sencilla y rapida. <br>
            Inicia ahora:</p>
            <button onclick='window.location="./crear_cuenta.php";' class='btn1'>Crear cuenta</button>
        </div>
    </main>
    
    <section id="ABC">
              <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                  <h1 class="display-4">PartyOwner</h1>
                  <p class="lead">"Invitaciones Personalizadas, Resultados Inolvidables"</p>
              </div> 
              <div class="container">
                  <div class="row justify-content-center">
                      <div class="col-lg-4 col-md-12">
                          <div class="card mb-4 shadow p-3 mb-5 bg-body">
                              <div class="card-body" style="text-align: center;">
                                <img src="./Images/icons8-party-80.png" alt="">
                                <p class="fw-bold" style="color: #e45858;">¿Quiénes somos?</p> <br>
                                <p style="text-align: justify;">Party Owner es una plataforma que te permite organizar fiestas y eventos de manera sencilla y
                                  rapida.
                                  Nuestro objetivo principal es simplificar y mejorar la forma en que planificas y gestionas tus
                                  eventos y quitarte una preocupación.
                                </p>
                              </div>
                          </div>
                      </div>  
                      <div class="col-lg-4 col-md-6">
                          <div class="card mb-4 shadow p-3 mb-5 bg-body">
                            <div class="card-body" style="text-align: center;">
                              <img src="./images/icons8-wedding-64.png" alt="">
                              <p class="fw-bold" style="color: #e45858;">¿Qué buscamos?</p> <br>
                              <p style="text-align: justify;"><b>Facilitar el registro de invitados: </b>Olvídate de las listas de invitados en papel y las largas
                                horas dedicadas a ingresar manualmente los nombres. <br>
                                <b>Mantener un registro preciso: </b>Mediante un código QR, PartyOwner te permite
              llevar un registro  de quiénes asistirán a tu evento.<br>
                              </p>
                            </div>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="card mb-4 shadow p-3 mb-5 bg-body">
                            <div class="card-body" style="text-align: center;">
                              <img src="./images/icons8-baby-shower-64.png" alt="">
                              <p class="fw-bold" style="color: #e45858;">¿Cómo funciona PartyOwner?</p> <br>
                              <p style="text-align: justify;">La aplicación "PartyOwner" simplifica la creación y gestión de invitaciones para eventos sociales. Puedes personalizar tus invitaciones, asignar códigos QR únicos y registrar a tus invitados. En el evento, puedes escanear los códigos QR para verificar la asistencia..</p>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>

    <footer>
        <div class='footer-container'>
            <div class='footer-logo'>
            <div class='logo'> 
                <img src="./assets/icons8-meeting.svg" alt="logo"class='logo'>
                <p>Party Owner</p>
            </div>
            </div>
            <div class='footer-links'>
                <a href="#">Acerca de</a>
                <a href="#">Contacto</a>
                <a href="#">Politicas de privacidad</a>
                <a href="#">Terminos y condiciones</a>
            </div>
        </div>
    </footer>
</body>
</html>