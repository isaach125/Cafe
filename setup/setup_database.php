<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/ProductRepository.php';
require_once __DIR__ . '/../src/UserRepository.php';

$productRepository = new Itb\ProductRepository();
$userRepository = new Itb\UserRepository();

$productRepository->dropTable();
$productRepository->createTable();
$productRepository->deleteAll();

$productRepository->insert('cheesecake', 4.20);
$productRepository->insert('pancake', 3.60);
$productRepository->insert('scone', 2.50);
$productRepository->insert('cookie', 2);


$userRepository->dropTable();
$userRepository->createTable();

/*$admin = new \Itb\User();
$admin->setId(3);
$admin->setUsername('admin');
$admin->setPassword('admin');
$admin->setRole(\Itb\User::ROLE_ADMIN);

$matt = new \Itb\User();
$matt->setId(1);
$matt->setUsername('matt');
$matt->setPassword('smith');
$matt->setRole(\Itb\User::ROLE_USER);

$isaac = new \Itb\User();
$isaac->setId(3);
$isaac->setUsername('isaac');
$isaac->setPassword('hong');
$isaac->setRole(\Itb\User::ROLE_USER);

// add users to the array
$this->users[1] = $admin;
$this->users[2] = $matt;
$this->users[3] = $isaac;*/