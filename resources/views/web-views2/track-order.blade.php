@extends('layouts.front-end.app')
@section('content')
<style>
    :root {
        --color-primary: #3577f0;
        --light-primary: #8c71db;
        --color-secondary: #ff497c;
        --color-tertiary: #FAB8C4;
        --color-white: #ffffff;
        --color-dark: #27272E;
        --color-black: #000000;
        --color-light: #CBD3D9;
        --color-lighter: #F6F7FC;
        --color-lightest: #C4C4C4;
        --color-chart01: #896BA7;
        --color-chart02: #BADEFF;
        --color-chart03: #E76458;
        --color-heading: #292930;
        --color-body: #777777;
        --color-border-light: #E3E6E9;
        --color-border-dark: #42424A;
        --color-gray: #999FAE;
        --color-midgray: #878787;
        --color-extra01: #999FAE;
        --color-success: #3EB75E;
        --color-danger: #FF0003;
        --color-warning: #FF8F3C;
        --color-info: #1BA2DB;
        --color-facebook: #3B5997;
        --color-twitter: #1BA1F2;
        --color-youtube: #ED4141;
        --color-linkedin: #0077B5;
        --color-pinterest: #E60022;
        --color-instagram: #C231A1;
        --color-vimeo: #00ADEF;
        --color-twitch: #6441A3;
        --color-discord: #7289da;
        --radius: 6px;
        --radius-big: 16px;
        --radius-small: 6px;
        --border-width: 2px;
        --border-thin: 1px;
        --p-light: 300;
        --p-regular: 400;
        --p-medium: 500;
        --p-semi-bold: 600;
        --p-bold: 700;
        --p-extra-bold: 800;
        --p-black: 900;
        --s-light: 300;
        --s-regular: 400;
        --s-medium: 500;
        --s-bold: 700;
        --s-black: 900;
        --shadow-primary: 0px 4px 10px rgba(37, 47, 63, 0.1);
        --shadow-light: 0 2px 6px 0 rgba(0, 0, 0, 0.05);
        --shadow-dark: 0 16px 32px 0 rgba(0, 0, 0, 0.04);
        --transition: 0.3s;
        --font-primary: "DM Sans", sans-serif;
        --font-secondary: "DM Sans", sans-serif;
        --font-awesome: "Font Awesome 5 Pro";
        --font-size-b1: 16px;
        --font-size-b2: 14px;
        --font-size-b3: 12px;
        --line-height-b1: 1.7;
        --line-height-b2: 1.65;
        --line-height-b3: 1.6;
        --h1: 46px;
        --h2: 36px;
        --h3: 28px;
        --h4: 24px;
        --h5: 20px;
        --h6: 18px;
    }

    :root {
        --bs-blue: #0d6efd;
        --bs-indigo: #6610f2;
        --bs-purple: #6f42c1;
        --bs-pink: #d63384;
        --bs-red: #dc3545;
        --bs-orange: #fd7e14;
        --bs-yellow: #ffc107;
        --bs-green: #198754;
        --bs-teal: #20c997;
        --bs-cyan: #0dcaf0;
        --bs-white: #fff;
        --bs-gray: #6c757d;
        --bs-gray-dark: #343a40;
        --bs-gray-100: #f8f9fa;
        --bs-gray-200: #e9ecef;
        --bs-gray-300: #dee2e6;
        --bs-gray-400: #ced4da;
        --bs-gray-500: #adb5bd;
        --bs-gray-600: #6c757d;
        --bs-gray-700: #495057;
        --bs-gray-800: #343a40;
        --bs-gray-900: #212529;
        --bs-primary: #0d6efd;
        --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
        --bs-primary-rgb: 13, 110, 253;
        --bs-secondary-rgb: 108, 117, 125;
        --bs-success-rgb: 25, 135, 84;
        --bs-info-rgb: 13, 202, 240;
        --bs-warning-rgb: 255, 193, 7;
        --bs-danger-rgb: 220, 53, 69;
        --bs-light-rgb: 248, 249, 250;
        --bs-dark-rgb: 33, 37, 41;
        --bs-white-rgb: 255, 255, 255;
        --bs-black-rgb: 0, 0, 0;
        --bs-body-color-rgb: 33, 37, 41;
        --bs-body-bg-rgb: 255, 255, 255;
        --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
        --bs-body-font-family: var(--bs-font-sans-serif);
        --bs-body-font-size: 1rem;
        --bs-body-font-weight: 400;
        --bs-body-line-height: 1.5;
        --bs-body-color: #212529;
        --bs-body-bg: #fff;
    }

    .widget-title {
        margin-left: 40px;
    }

    .axil-dashboard-aside {
        border: 1px solid var(--color-light);
        padding: 40px 35px 30px;
        border-radius: 6px;
    }

    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    nav,
    section,
    summary {
        display: block;
    }

    * {
        box-sizing: border-box;
    }

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    * {
        box-sizing: border-box;
    }

    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    nav,
    section,
    summary {
        display: block;
    }

    .axil-dashboard-aside .nav-tabs {
        border-bottom: none;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .nav {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    * {
        box-sizing: border-box;
    }

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .axil-dashboard-aside .nav-link.active,
    .axil-dashboard-aside .nav-link:hover {
        background-color: var(--color-lighter);
        color: var(--color-primary);
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .axil-dashboard-aside .nav-link {
        font-weight: 500;
        color: var(--color-body);
        font-size: var(--font-size-b2);
        position: relative;
        border-radius: 6px;
        padding: 9px 10px 9px 55px;
        margin-bottom: 8px;
        transition: var(--transition);
        border: none;
        width: 100%;
    }

    .nav-tabs .nav-link {
        margin-bottom: -1px;
        background: 0 0;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .nav-link {
        display: block;
        padding: 0.5rem 1rem;
        color: #0d6efd;
        text-decoration: none;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
    }

    /* container css */
    .container,
    .container-fluid,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        padding-left: 15px;
        padding-right: 15px;
    }

    @media (min-width: 768px) .mb-md-4 {
        margin-bottom: 1.5rem !important;
    }

    .pb-5 {
        padding-bottom: 3rem !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    @media (min-width: 1400px) .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        max-width: 1320px;
    }

    @media (min-width: 1200px) .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl {
        max-width: 1140px;
    }

    @media (min-width: 992px) .container,
    .container-lg,
    .container-md,
    .container-sm {
        max-width: 960px;
    }

    @media (min-width: 768px) .container,
    .container-md,
    .container-sm {
        max-width: 720px;
    }

    @media (min-width: 576px) .container,
    .container-sm {
        max-width: 540px;
    }

    .container,
    .container-fluid,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        width: 100%;
        padding-right: var(--bs-gutter-x, .75rem);
        padding-left: var(--bs-gutter-x, .75rem);
        margin-right: auto;
        margin-left: auto;
    }
</style>


<!-- style for my order section -->
<style>
    .cancel:hover {
        background-color: red !important;
        border-color: red !important;
    }

    .badge {
        display: inline;
        padding: .25em .4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem
    }

    .badge:empty {
        display: none
    }

    .btn .badge {
        position: relative;
        top: -1px
    }

    .badge-pill {
        padding-right: .6em;
        padding-left: .6em;
        border-radius: 10rem
    }

    .badge-primary {
        color: #fff;
        background-color: #007bff
    }

    .badge-primary[href]:focus,
    .badge-primary[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #0062cc
    }

    .badge-secondary {
        color: #fff;
        background-color: #6c757d
    }

    .badge-secondary[href]:focus,
    .badge-secondary[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #545b62
    }

    .badge-success {
        color: #fff;
        background-color: #28a745
    }

    .badge-success[href]:focus,
    .badge-success[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #1e7e34
    }

    .badge-info {
        color: #fff;
        background-color: #17a2b8
    }

    .badge-info[href]:focus,
    .badge-info[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #117a8b
    }

    .badge-warning {
        color: #212529;
        background-color: #ffc107
    }

    .badge-warning[href]:focus,
    .badge-warning[href]:hover {
        color: #212529;
        text-decoration: none;
        background-color: #d39e00
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545
    }

    .badge-danger[href]:focus,
    .badge-danger[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #bd2130
    }

    .badge-light {
        color: #212529;
        background-color: #f8f9fa
    }

    .badge-light[href]:focus,
    .badge-light[href]:hover {
        color: #212529;
        text-decoration: none;
        background-color: #dae0e5
    }

    .badge-dark {
        color: #fff;
        background-color: #343a40
    }

    .badge-dark[href]:focus,
    .badge-dark[href]:hover {
        color: #fff;
        text-decoration: none;
        background-color: #1d2124
    }
</style>

<style>
    @media (min-width: 1200px) .container {
        max-width: 1225px !important;
    }

    .nav-item {
        margin: 6px 0px !important;
    }

    @media (min-width: 1200px) .col-xl-9 {
        flex: 0 0 auto;
        width: 75%;
    }

    @media (min-width: 768px) .col-md-8 {
        flex: 0 0 auto;
        width: 66.66666667%;
    }

    .fade {
        transition: opacity .15s linear;
    }

    .mt-2 {
        margin-top: 10px;
    }

    .mb-2 {
        margin-bottom: 10px;
    }

    .m-10 {
        margin: 10px;
    }

    

    .nav-link.active {
        color: #0d6efd !important;
    }

    

    .py-5 {
        padding: 3rem;
    }

    .axil-dashboard-aside .nav-link i {
        position: unset !important;
    }

    .table>tbody>tr>td,
    .table>tfoot>tr>td,
    .table>thead>tr>td {
        padding: 10px 10px !important;
    }

    
</style>

<style>
    .axil-dashboard-warp .axil-dashboard-author {
        margin-bottom: 50px
    }

    .axil-dashboard-warp .axil-dashboard-author .media {
        align-items: center
    }

    .axil-dashboard-warp .axil-dashboard-author .thumbnail {
        margin-bottom: 10px
    }

    .axil-dashboard-warp .axil-dashboard-author .thumbnail img {
        border-radius: 50%
    }

    .axil-dashboard-warp .axil-dashboard-author .joining-date {
        font-size: 14px;
        color: var(--color-body);
        font-weight: var(--s-medium)
    }

    .axil-dashboard-warp .tab-content {
        padding-left: 45px
    }

    @media only screen and (max-width: 1199px) {
        .axil-dashboard-warp .tab-content {
            padding-left: 0
        }
    }

    .axil-dashboard-aside {
        border: 1px solid var(--color-light);
        padding: 40px 35px 30px;
        border-radius: 6px
    }

    @media only screen and (min-width: 768px)and (max-width: 991px) {
        .axil-dashboard-aside {
            padding: 30px 15px 20px
        }
    }

    @media only screen and (max-width: 767px) {
        .axil-dashboard-aside {
            margin-bottom: 40px
        }
    }

    .axil-dashboard-aside .nav-tabs {
        border-bottom: none
    }

    .axil-dashboard-aside .nav-link {
        font-weight: 500;
        color: var(--color-body);
        font-size: var(--font-size-b2);
        position: relative;
        border-radius: 6px;
        padding: 9px 10px 9px 55px;
        margin-bottom: 8px;
        transition: var(--transition);
        border: none;
        width: 100%
    }

    @media only screen and (min-width: 768px)and (max-width: 991px) {
        .axil-dashboard-aside .nav-link {
            padding: 9px 10px 9px 40px
        }
    }

    .axil-dashboard-aside .nav-link i {
        position: absolute;
        top: 12px;
        left: 24px;
        font-size: 18px
    }

    @media only screen and (min-width: 768px)and (max-width: 991px) {
        .axil-dashboard-aside .nav-link i {
            left: 10px
        }
    }

    .axil-dashboard-aside .nav-link.active,
    .axil-dashboard-aside .nav-link:hover {
        background-color: var(--color-lighter);
        color: var(--color-primary)
    }

    .axil-dashboard-overview .welcome-text {
        color: var(--color-black);
        font-size: 18px;
        margin-bottom: 25px
    }

    .axil-dashboard-overview .welcome-text span {
        font-weight: var(--p-bold)
    }

    .axil-dashboard-overview .welcome-text a {
        color: var(--color-chart03);
        transition: var(--transition)
    }

    .axil-dashboard-overview .welcome-text a:hover {
        color: var(--color-primary)
    }

    .axil-dashboard-overview p {
        font-size: var(--font-size-b1)
    }

    .axil-dashboard-order .table {
        font-family: var(--font-secondary)
    }

    .axil-dashboard-order .table thead {
        background-color: var(--color-lighter)
    }

    .axil-dashboard-order .table thead th {
        border: none;
        padding: 18px 20px;
        vertical-align: middle;
        font-size: 20px;
        font-weight: var(--p-medium);
        text-transform: capitalize
    }

    .axil-dashboard-order .table thead th:first-child {
        border-radius: 6px 0 0 6px
    }

    .axil-dashboard-order .table thead th:last-child {
        border-radius: 0 6px 6px 0;
        padding-right: 30px;
        text-align: right
    }

    @media only screen and (max-width: 1199px) {
        .axil-dashboard-order .table thead th {
            font-size: 18px
        }
    }

    .axil-dashboard-order .table tbody {
        border-top: none
    }

    .axil-dashboard-order .table tbody tr td,
    .axil-dashboard-order .table tbody tr th {
        padding: 20px 20px;
        vertical-align: middle;
        font-weight: var(--p-medium);
        font-size: var(--font-size-b2);
        color: var(--color-heading);
        border-top: none;
        border-bottom: 2px solid var(--color-lighter)
    }

    .axil-dashboard-order .table tbody tr td:last-child,
    .axil-dashboard-order .table tbody tr th:last-child {
        text-align: right
    }

    .axil-dashboard-order .table tbody tr th {
        color: var(--color-chart03)
    }

    /* .axil-dashboard-order .table tbody tr td {
    min-width: 150px
    } */
    .axil-dashboard-author .media .thumbnail img {
        border-radius: 50%;
    }

    .lhov:hover {
        cursor: pointer;
    }

    .axil-dashboard-order .table tbody tr:first-child td,
    .axil-dashboard-order .table tbody tr:first-child th {
        border-top: none
    }

    .axil-dashboard-order .table tbody .view-btn {
        padding: 2px 10px;
        border: 1px solid var(--color-body);
        background-color: rgba(0, 0, 0, 0);
        color: var(--color-dark)
    }

    .axil-dashboard-order .table tbody .view-btn:before {
        display: none
    }

    .axil-dashboard-order .table tbody .view-btn:after {
        display: none
    }

    .axil-dashboard-order .table tbody .view-btn:hover {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white)
    }

    .axil-dashboard-address .notice-text {
        font-size: var(--font-size-b2);
        color: #292930
    }

    .axil-dashboard-address .addrss-header {
        border-bottom: 1px solid var(--color-light);
        padding-bottom: 20px;
        margin-bottom: 20px
    }

    .axil-dashboard-address .title {
        font-weight: var(--p-medium);
        color: #292930
    }

    @media only screen and (min-width: 992px)and (max-width: 1199px) {
        .axil-dashboard-address .title {
            font-size: 26px
        }
    }

    .axil-dashboard-address .address-edit {
        font-size: var(--font-size-b2);
        color: #292930;
        transition: var(--transition)
    }

    .axil-dashboard-address .address-edit:hover {
        color: var(--color-primary)
    }

    .axil-dashboard-address ul li {
        font-size: var(--font-size-b2);
        line-height: var(--line-height-b2);
        color: #292930;
        font-family: var(--font-primary)
    }

    .axil-dashboard-account .form-group .form-control {
        height: 60px;
        padding: 10px 30px;
        border-color: var(--color-light);
        color: var(--color-body)
    }

    .axil-dashboard-account .form-group select option:hover {
        background: red !important;
        color: red
    }
</style>






<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/css/bootstrap.css"
    integrity="sha512-KsdCRnLXUKDOyOPhhh7EjWSh2Mh/ZI64XwaYQPGyvuQYWBE1FGTCPnUKjLvD+DDQevQdks3US94aYJsIQxTiKg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer">

<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="container text-center">
    <h3 class="headerTitle my-3">My order</h3>
</div>
<div class="container">
    <div class="row">
        <!-- Sidebar-->
        <style>
            .widget-title {
                margin-left: 40px;

            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
            integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
            crossorigin="anonymous" referrerpolicy="no-referrer">

        @include('layouts.front-end.partials.user-side-panel')

        <!-- Content  -->
        <div class="col-xl-9 col-md-8 bg-white" style="border: 1px solid #CBD3D9;border-radius: 6px !important;">
            <div class="container rtl py-5 ">
                <div class="__max-w-620 m-10 ">
                    <h3 class="text-center text-capitalize">Track Order</h3>
                    <div class="card">
                        <div class="card-body m-10" >
                            <form action="http://localhost/sync/track-order/result" type="submit" method="post" class="p-3">
                                <input type="hidden" name="_token" value="MdLS4OzLnOkv7y8DeNlwPOZBoIOiJ1maQ58M63YW">

                                <div class="form-group mb-4">
                                    <input class="form-control prepended-form-control" type="text" name="order_id" placeholder="Order id" required="">
                                </div>
                                <div class="form-group mb-4">
                                    <input class="form-control prepended-form-control" type="text" name="phone_number" placeholder="Your phone number" required="">
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary" style="width: 200px;font-size: 18px;" type="submit" name="trackOrder">Track Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection