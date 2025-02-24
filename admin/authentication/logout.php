<?php
session_start(); // Oturumu başlat

// Tüm oturum değişkenlerini sil
session_unset();

// Oturumu tamamen yok et
session_destroy();

// Kullanıcıyı login sayfasına yönlendir
header("Location: /login");
exit;
