<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo base_url('user/dashboard'); ?>" class="brand-link">
        <img src="/assets/templates/adminlte320/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Hallyu Sampah!</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
                if ($photo == '') { ?>
                    <img src="/images/nasabah/no_image.gif" class="img-circle elevation-2" alt="User Image">
                <?php
                } else { ?>
                    <img src="/images/nasabah/<?= $foto; ?>" class="img-circle elevation-2" alt="User Image">
                <?php
                }
                ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $customer_name; ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url('user/dashboard'); ?>" class="nav-link <?php if ($page == 'dashboard') echo " active";  ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/transaksi-setor-sampah'); ?>" class="nav-link <?php if ($page == 'transaksi-setor-sampah') echo " active";  ?>">
                        <i class="nav-icon fas fa-trash-alt"></i>
                        <p>Setor Sampah</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/transaksi-saldo'); ?>" class="nav-link <?php if ($page == 'transaksi-saldo') echo " active";  ?>">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>Penarikan Saldo</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/rekening'); ?>" class="nav-link <?php if ($page == 'rekening') echo " active";  ?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>Data Rekening</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/profile'); ?>" class="nav-link <?php if ($page == 'profil') echo " active";  ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Pengaturan Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link" id="logout">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>