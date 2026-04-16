<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />

    <!--====== Title ======-->
    <title>Survei Kepuasan</title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--====== Favicon Icon ======-->
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/png"
    />

    <!--====== CSS Files LinkUp ======-->
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/lineIcons.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

    <!--====== CSS Files LinkUp ======-->
    <link rel="stylesheet" href="{{ asset('assets/fonts/LineIcons.svg') }}">

  </head>

  <body>
    <!--====== PRELOADER PART START ======-->
    <div class="preloader">
      <div class="loader">
        <div class="spinner">
          <div class="spinner-container">
            <div class="spinner-rotator">
              <div class="spinner-left">
                <div class="spinner-circle"></div>
              </div>
              <div class="spinner-right">
                <div class="spinner-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--====== PRELOADER PART ENDS ======-->

<!--====== HEADER PART START ======-->
<header class="header-area">
  <div class="navbar-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="https://lpm.umbjm.ac.id/">
              <img src="assets/images/logo/logo (1).png" alt="Logo (1)" class="img-fluid" style="max-width: 180px; height: auto;" />
            </a>

            <!-- === PERUBAAN DIMULAI DI SINI === -->
            <!-- Wrapper untuk Toggler dan Tombol Login Mobile -->
            <div class="d-lg-none ms-auto d-flex align-items-center">
                <!-- Tombol Login untuk Mobile (di luar dropdown) -->
                <a class="main-btn me-2" href="{{ url('/login') }}" style="padding: 8px 15px; font-size: 0.9rem;">
                    <i class="lni lni-user"></i> Login
                </a>

                <!-- Tombol Hamburger -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="toggler-icon"> </span>
                    <span class="toggler-icon"> </span>
                    <span class="toggler-icon"> </span>
                </button>
            </div>
            <!-- === PERUBAAN BERAKHIR DI SINI -->

            <div
              class="collapse navbar-collapse sub-menu-bar"
              id="navbarSupportedContent"
            >
              <ul id="nav" class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a class="page-scroll active" href="#home">Tampilan Utama</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#about">Tentang</a>
                </li>
                
                <!-- Tombol Login untuk Desktop (di dalam navbar-collapse) -->
                <li class="nav-item d-none d-lg-block">
                  <a class="main-btn btn-sm px-5" href="{{ url('/login') }}">Login</a>
                </li>
              </ul>
            </div>
            <!-- navbar collapse -->

              </nav>
              <!-- navbar -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- navbar area -->

      <div
        id="home"
        class="header-hero bg_cover"
        style="background-image: url(assets/images/header/banner-bg.svg)"
      >
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
              <div class="header-hero-content text-center">
                <h2
                  class="header-title wow fadeInUp"
                  data-wow-duration="1.3s"
                  data-wow-delay="0.5s"
                >
                  Lembaga Penjaminan Mutu - LPM
                </h2>
                <p
                  class="text wow fadeInUp"
                  data-wow-duration="1.3s"
                  data-wow-delay="0.8s"
                >
                Selamat datang di survei kepuasan LPM, 
                masukan Anda sangat penting bagi kami untuk meningkatkan kualitas layanan yang kami berikan.
                </p>
              </div>
              <!-- header hero content -->
            </div>
          </div>
          <!-- row -->
          <div class="row">
            <div class="col-lg-12">
              <div
                class="header-hero-image text-center wow fadeIn"
                data-wow-duration="1.3s"
                data-wow-delay="1.4s"
              >
                <img src="assets/images/header/header-hero.png" alt="hero" class="img-fluid" style="max-height: 400px; object-fit: contain;"/>
              </div>
              <!-- header hero image -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
        <div id="particles-1" class="particles"></div>
      </div>
      <!-- header hero -->
    </header>
    <!--====== HEADER PART ENDS ======-->

    <!--====== BRAND PART START ======-->
    <div class="brand-area pt-90">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div
              class="
                brand-logo
                d-flex
                align-items-center
                justify-content-center justify-content-md-between
              "
            >
              <div
                class="single-logo mt-30 wow fadeIn"
                data-wow-duration="1s"
                data-wow-delay="0.2s"
              >
                <!-- <img src="#" alt="brand" /> -->
              </div>

              <!-- single logo -->
            </div>
            <!-- brand logo -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>
    <!--====== BRAND PART ENDS ======-->

    <!--====== SERVICES PART START ======-->
    <section id="features" class="services-area pt-120">
      
    <section id="about">
      <!--====== ABOUT PART START ======-->
      <div class="about-area pt-70">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div
                class="about-content mt-50 wow fadeInLeftBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <div class="section-title">
                  <div class="line"></div>
                  <h3 class="title">
                    Visi Misi dan Tujuan Universitas Muhammadiyah Banjarmasin
                  </h3>
                </div>
                <!-- section title -->
                <p class="text">
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Visi:</h4>
                      <p>
                      Menjadi universitas terkemuka, unggul, profesional, berkarakter Islam yang berkemajuan tahun 2026.
                      </p>
                    </br>
                  </div>

                  <!-- Misi Section -->
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Misi:</h4>
                        <ul style="list-style: none; padding-left: 0;">
                          <li>
                              <div style="display: flex; align-items: flex-start;">
                                  <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                                  <span>Menyelenggarakan Pendidikan Akademik, Vokasi, dan Profesi untuk pengembangan ilmu, profesionalisme, dan pembentukan peserta didik berkarakter Islam yang berkemajuan.</span>
                              </div>
                              <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                          </li>
                          <li>
                              <div style="display: flex; align-items: flex-start;">
                                  <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                                  <span>Menyelenggarakan Penelitian dasar dan terapan, produk yang inovatif, berkualitas untuk menunjang kemandirian bangsa.</span>
                              </div>
                              <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                          </li>
                          <li>
                              <div style="display: flex; align-items: flex-start;">
                                  <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                                  <span>Mengabdikan keahlian dalam bidang ilmu pengetahuan, teknologi, dan seni untuk kepentingan masyarakat, kerja sama yang produktif dan berkelanjutan dengan kelembagaan Pendidikan, pemerintahan, dan dunia usaha di tingkat daerah, nasional, dan internasional.</span>
                              </div>
                              <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                          </li>
                          <li>
                              <div style="display: flex; align-items: flex-start;">
                                  <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                                  <span>Mengembangkan organisasi dalam meningkatkan kualitas tata kelola yang baik (good university governance), menuju tata kelola yang unggul (excellent university governance), secara efektif dan efisien dalam suasana akademik yang islami dan bermartabat.</span>
                              </div>
                              <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                          </li>
                        </ul>
                      </br>
                    </div>

                    <!-- Tujuan Section -->
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Tujuan:</h4>
                  
                  <ul style="list-style: none; padding-left: 0;">
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menghasilkan lulusan yang berdaya saing global, profesional, mempunyai spirit unggul, dan berkarakter Islam yang berkemajuan.</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Mewujudkan pengembangan dan pemanfaatan iptek dan seni yang relevan dengan tujuan pembangunan nasional dan daerah melalui penyelenggaraan program studi.</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Penelitian, pembinaan kelembagaan, serta pengembangan sumber daya akademik yang berdaya guna dan berhasil guna.</span>
                          </div>
                      </li>
                    </br>
                  </ul>
                  </div>
                  </p>
              </div>              
            <!-- about content -->
            </div>
            <div class="col-lg-6">
              <div
                class="about-image text-center mt-50 wow fadeInRightBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <!-- RESPONSIVE: Buat gambar lebih fleksibel -->
                <img src="assets/images/about/about1.png" alt="about" class="img-fluid" style="max-height: 350px; object-fit: contain;"/>
              </div>
              <!-- about image -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
        <div class="about-shape-1 d-none d-lg-block">
          <img src="assets/images/about/about-shape-1.svg" alt="shape" />
        </div>
      </div>
      <!--====== ABOUT PART ENDS ======-->

      <!--====== ABOUT PART START ======-->
      <div class="about-area pt-70">
        <div class="about-shape-2 d-none d-lg-block">
          <img src="assets/images/about/about-shape-2.svg" alt="shape" />
        </div>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 order-lg-last">
              <div
                class="about-content ms-lg-auto mt-50 wow fadeInLeftBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <div class="section-title">
                  <div class="line"></div>
                  <h3 class="title">
                    Visi Misi dan Tujuan Lembaga Penjaminan Mutu Universitas Muhammadiyah Banjarmasin
                  </h3>
                </div>
                <!-- section title -->
                <p class="text">
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Visi:</h4>
                      <p>
                          Menjamin peningkatan kualitas output Universitas Muhammadiyah Banjarmasin yang Professional, Unggul, dan Islami.
                      </p>
                    </br>
                  </div>

                  <!-- Misi Section -->
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Misi:</h4>
                  <ul style="list-style: none; padding-left: 0;">
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menyelenggarakan penjaminan mutu internal (SPMI-PT) dengan Standar Nasional Pendidikan yang dikembangkan.</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menjamin peningkatan kualitas Institusi/ Fakultas/ Prodi melalui ketercapaian Akreditasi dengan prinsip perbaikan berkelanjutan.</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menyelenggarakan fungsi kelembagaan Penjaminan Mutu.</span>
                          </div>
                      </li>
                  </ul>
                  </br>
                  </div>

                  <!-- Tujuan Section -->
                  <div class="fancy-title title-double-border title-center">
                    <br>
                      <h4>Tujuan:</h4>
                  
                  <ul style="list-style: none; padding-left: 0;">
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menjadikan LPM UM BANJARMASIN sebagai sumber informasi evaluasi mutu terhadap pelaksanaan layanan pendidikan (akademik).</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menjadikan LPM UM BANJARMASIN sebagai sumber informasi evaluasi mutu terhadap pelaksanaan layanan non akademik.</span>
                          </div>
                          <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
                      </li>
                      <li>
                          <div style="display: flex; align-items: flex-start;">
                              <span style="font-weight: bold; color: #555; margin-right: 10px; flex-shrink: 0;">•</span>
                              <span>Menjadikan LPM UM BANJARMASIN sebagai pusat data pengembangan mutu program studi melalui akreditasi.</span>
                          </div>
                      </li>
                    </br>
                  </ul>
                  </div>
                </p>
              </div>
              <!-- about content -->
            </div>
            <div class="col-lg-6 order-lg-first">
              <div
                class="about-image text-center mt-50 wow fadeInRightBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <!-- RESPONSIVE: Buat gambar lebih fleksibel -->
                <img src="assets/images/about/about2.png" alt="about" class="img-fluid" style="max-height: 350px; object-fit: contain;"/>
              </div>
              <!-- about image -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!--====== ABOUT PART ENDS ======-->

      <!--====== ABOUT PART START ======-->
      <div class="about-area pt-70">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div
                class="about-content mt-50 wow fadeInLeftBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <div class="section-title">
                  <div class="line"></div>
                  <h3 class="title">
                  Bidang Pusat Data dan Informasi
                  </h3>
                </div>
                <!-- section title -->
                <p class="text">
                Mengembangkan dan mengelola sistem informasi yang meningkatkan efisiensi dan efektivitas 
                pelaksananaan sistem penjaminan mutu baik SPMI maupun SPME.
                </p>
              </div>
              <!-- about content -->
            </div>
            <div class="col-lg-6">
              <div
                class="about-image text-center mt-50 wow fadeInRightBig"
                data-wow-duration="1s"
                data-wow-delay="0.5s"
              >
                <!-- RESPONSIVE: Buat gambar lebih fleksibel -->
                <img src="assets/images/about/about3.png" alt="about" class="img-fluid" style="max-height: 350px; object-fit: contain;"/>
              </div>
              <!-- about image -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
        <div class="about-shape-1 d-none d-lg-block">
          <img src="assets/images/about/about-shape-1.svg" alt="shape" />
        </div>
      </div>
      <!--====== ABOUT PART ENDS ======-->
    </section>

    <!--====== FOOTER PART START ======-->
    <footer id="footer" class="footer-area pt-120">
        <!-- row -->
        </div>
        <!-- subscribe area -->
        <div class="footer-widget pb-100">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8">
              <div
                class="footer-about mt-50 wow fadeIn"
                data-wow-duration="1s"
                data-wow-delay="0.2s"
              >
                <!-- RESPONSIVE: Batasi lebar logo di footer -->
                <a class="logo" href="javascript:void(0)">
                  <img src="assets/images/logo/logo (1).png" alt="logo" style="max-width: 150px; height: auto;"/>
                </a>
                <ul class="social">
                  <li>
                    <a target="_blank" href="https://twitter.com/Kerry14066781">
                      <i class="lni lni-twitter-filled"> </i>
                    </a>
                  </li>
                  <li>
                    <a
                      target="_blank"
                      href="https://www.instagram.com/bestpicturesinweb/"
                    >
                      <i class="lni lni-instagram-filled"> </i>
                    </a>
                  </li>
                  <li>
                    <a
                      target="_blank"
                      href="https://www.linkedin.com/in/dada-khalandar/"
                    >
                      <i class="lni lni-linkedin-original"> </i>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" href="https://github.com/kerrybli">
                      <i class="lni lni-github-original"> </i>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- footer about -->
            </div>
            
        <!-- footer widget -->
        <div class="footer-copyright">
          <div class="row">
            <div class="col-lg-12">
              <div class="copyright d-sm-flex justify-content-between">
                <div class="copyright-content text-center text-sm-start">
                  <p class="text">
                    Designed and Developed with
                    <span style="color: red; font-size: 25px">♥️ </span> by
                    <a
                      href="https://www.instagram.com/riddd.farid_/profilecard/?igsh=dWY5am1sOTdib252"
                      target="_blank"
                      >Muhammad Farid Zikrullah</a
                    >
                  </p>
                </div>
                <!-- copyright content -->
              </div>
              <!-- copyright -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- footer copyright -->
      </div>
      <!-- container -->
      <div id="particles-2"></div>
    </footer>
    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TOP TOP PART START ======-->
    <a href="#" class="back-to-top"> <i class="lni lni-chevron-up"> </i> </a>
    <!--====== BACK TOP TOP PART ENDS ======-->

    <!--====== Javascript Files ======-->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/count-up.min.js"></script>
    <script src="assets/js/particles.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
