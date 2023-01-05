<?= $this->extend('Layouts/Users/user-layout.php') ?>
<?= $this->section('header') ?>

<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/templates/adminlte320/img/img-earth.jpg" alt="logo">
            <span>Hallyu Sampah!</span>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">Tentang</a></li>
                <li><a class="nav-link scrollto" href="#features">Visi & Misi</a></li>
                <li><a class="nav-link scrollto" href="#faq">Pertanyaan</a></li>
                <li><a class="nav-link scrollto" href="#contact">Kontak Kami</a></li>
                <li><a class="getstarted scrollto" href="/user" target="_blank">Login</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>

<section id="hero" class="hero d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">Sehat itu mahal, jagalah kebersihan kamu & keluarga!</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">
                   Yuk kirim sampah kamu yang ada dirumah/disekitar kamu, kami tukar dengan uang.
                </h2>
                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                        <a href="user/register" target="_blank" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>Daftar Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="assets/templates/flexstart/assets/img/2.jpeg" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main id="main">
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="row gx-0">

                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h2>Tentang Kami</h2>
                        <p>
                            Hallyu Sampah! merupakan wadah penampungan sampah dari STTI NIIT ITech yang akan ditransfer ke perusahaan limbah sampah, untuk mengurangi limbah di masyarakat Indonesia.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/templates/flexstart/assets/img/1.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Visi & Misi</h2>
                <p>Berikut Visi dan Misi kami</p>
            </header>
            <div class="row feture-tabs" style="margin-top: -20px;" data-aos="fade-up">
                <div class="col-lg-12">
                    <ul class="nav nav-pills mb-3">
                        <li>
                            <a class="nav-link active" data-bs-toggle="pill" href="#tab1">Visi</a>
                        </li>
                        <li>
                            <a class="nav-link" data-bs-toggle="pill" href="#tab2">Misi</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Berkontribusi Dalam Mengurangi Limbah Yang Masih Dapat Didaur Ulang Sehingga Dapat Menjaga Kelestarian Lingkungan</h4>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="tab2">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Berkontribusi Signifikan Dalam Mengurangi Polusi Limbah Nasional Dan Menciptakan Lingkungan Hidup Yang Ideal Dan Berkelanjutan</h4>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Meningkatkan Tingkat Daur Ulang Sampah Organik Dan Anorganik Di Indonesia</h4>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check2"></i>
                                <h4>Membantu Menyalurkan Limbah Yang Dapat Didaur Ulang Kepada Perusahaan Pengolah Limbah</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="faq">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>FAQ</h2>
                <p>Pertanyaan dan Jawaban</p>
            </header>
            <div class="row">
                <div class="col-lg-6">
                    <div class="accordion accordion-flush" id="faqlist1">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                                    Bagaimana cara memakai aplikasi ini?
                                </button>
                            </h2>
                            <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                   Step apa saja yang perlu disiapkan, untuk menukar sampah ini dengan uang?
                                </button>
                            </h2>
                            <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                <div class="accordion-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="accordion accordion-flush" id="faqlist2">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-1">
                                   Berapa hari pengambilan sampah? dari proses daftar mendaftar?
                                </button>
                            </h2>
                            <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                                   Saldo akan masuk kemana dan bagaimana cara mengambilnya?
                                </button>
                            </h2>
                            <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                <div class="accordion-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Kontak</h2>
                <p>Hubungi Kami</p>
            </header>
            <div class="row gy-4">
                <div class="col-lg-12">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Alamat</h3>
                                <p>Jl. Asem Dua No.22, RT.3/RW.4, Cipete Sel., Kec. Cilandak, <br>Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12410</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Telepon</h3>
                                <p>(021)7515870</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Jam Buka</h3>
                                <p>Monday<br>09.00 - 15.00</p>
                                <p>Selasa<br>09.00 - 15.00</p>
                                <p>Rabu<br>09.00 - 15.00</p>
                                <p>Kamis<br>09.00 - 15.00</p>
                                <p>Jumat<br>09.00 - 15.00</p>
                                <p>Sabtu<br>09.00 - 15.00</p>
                                <p>Minggu<br>Tutup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>