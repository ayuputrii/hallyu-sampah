<?= $this->extend('/Layouts/Users/index') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-primary">
                        <i class="icon fas fa-user"></i> Selamat Datang
                        <strong><?= $customer_name; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp. <?= number_format($balance, 0, ".", "."); ?></h3>
                            <p>Total Saldo</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <a href="<?php echo base_url('user/penarikan-saldo'); ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $db      = \Config\Database::connect();
                            $builder = $db->table('tb_transaction a');
                            $builder->select('a.id, a.id_customer, b.customer_name');
                            $builder->join('nasabah b', 'b.id = a.id_customer', 'left');
                            $builder->where(['a.id_customer' => $id]);
                            $builder->where(['a.status' => 'Berhasil']);
                            $berhasil = $builder->countAllResults();
                            ?>
                            <h3><?= $berhasil; ?></h3>
                            <p>Penarikan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <a href="transaksi-penarikan" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            $db      = \Config\Database::connect();
                            $builder = $db->table('tb_rubbish_deposit a');
                            $builder->select('a.id, a.id_customer, b.customer_name');
                            $builder->join('nasabah b', 'b.id = a.id_customer', 'left');
                            $builder->where(['a.id_customer' => $id]);
                            $builder->where(['a.status' => 'Berhasil']);
                            $berhasil = $builder->countAllResults();
                            ?>
                            <h3><?= $berhasil; ?></h3>
                            <p>Setor Sampah</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <a href="transaksi-setor-sampah" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>