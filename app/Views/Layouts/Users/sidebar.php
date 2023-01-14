<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?php echo base_url('admin/dashboard'); ?>" class="brand-link" style="display: flex; flex-direction: row; margin-left: 12px;">
    <img alt="logo" class="mb-2 img-circle elevation-2 mr-2" src="/assets/templates/adminlte320/img/img-earth.jpg" height="35" width="35"><br>
    <span class="brand-text font-weight-light mt-1">Hallyu Sampah!</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
        if ($photo == '') { ?>
            <img src="/images/customer/no_image.gif" class="img-circle elevation-2" alt="User Image">
        <?php
        } else { ?>
            <img src="/images/customer/<?= $photo; ?>" class="img-circle elevation-2" alt="User Image">
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
          <a href="<?php echo base_url('user/penarikan-saldo'); ?>" class="nav-link <?php if ($page == 'penarikan-saldo') echo " active";  ?>">
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
          <a href="<?php echo base_url('user/profil'); ?>" class="nav-link <?php if ($page == 'profil') echo " active";  ?>">
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