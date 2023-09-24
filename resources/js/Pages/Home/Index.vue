<script setup>

import { Head } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue';
import { onMounted } from 'vue';



let props = defineProps({
    title: String,

});

let banner_data = {
    title_1: 'TEST TASK - LIBRARY<br><span class="text-red-600">CRUD | REST API | Email Verification | Socialite | Laratrust | L5-Swagger | QuillEditor | Intervention Image | "Feature" tests </span>',
    showText: {
        0: [
            'filter',
            'Filters & sorting',
            ['global filter', 'global sorting', 'local sorting'],
            'Filtering, sorting and pagination are developed using cookies and local storage.<br>Filters work on all relational tables at once: books, authors, likes, tags, categories, types and genres.',
        ],
        1: [
            'swagger',
            'Doc API: L5-Swagger',
            ['get / post', 'delete', 'put / patch'],
            'WriterController.<br>Index - list ofwriters. Create and store the writer. Show - one writer.<br>Delete - the writer. Update - the writer.',
        ],
        2: [
            'chart',
            'Vue-chart-3',
            ['chart & table', 'summary information', 'in details - most popular'],
            'Characteristic information from the database by popularity.<br>The rating of the first 10 positions is displayed in charts and tables - via a switch.',
        ],
        3: [
            'test',
            'Feature tests',
            ['CRUD roles / permissions', 'Inertia Testing Assert', 'valid / invalid data'],
            'Create and Update - check with validation.<br>Show - starus and attributes of response. View - Inertia, component and properties.<br>Delete - auth, roles and permissions.'
        ],
        4: [
            'socialite',
            'Socialite',
            ['Google & GitHub', 'roles & rermissions', 'test-Email for login'],
            'You can log into the system through Google and GitHub through your own account - the Reader role will be automatically assigned. Only an Administrator can change the role.<br>You can use three sample-accounts with one password - Administrator, Moderator and Reader.'
        ],
        5: [
            'image',
            'Intervention Image',
            ['uploading image', 'resizing', 'storing image'],
            'The package was installed for both client and server side use.<br>The client side provides convenient selection of the image file.<br>The server stores two versions of file - basic and resized.'
        ],
        6: [
            'package',
            'NPM package',
            ['MultiRangeSlider.vue', 'Vue 3 Multiselect', 'QuillEditor'],
            'Vue packages were installed to create, update, and search the books in the database.<br>MultiRangeSlider.vue; Multiselect Checkboxed; Vue 3 Multiselect; QuillEditor.'
        ],
        7: [
            'edit',
            'Simple editing',
            ['editing in table row', 'creating data in row', 'no page for edit/create'],
            'Editing or creation data is performed in a row of the current table - without using additional pages.<br>Click button on the page or just press key Enter / Esc on the keyboard.'
        ],
        8: [
            'belongs',
            'BelongsToThrough',
            ['relationship', 'belongsToThrough', 'Book → TypeGenre → Genre'],
            'This package HasManyThrough allows BelongsToThrough relationships with unlimited intermediate models.<br>Used the BelongsToThrough trait in Book model to define the inverse relationship:<br>Book → belongs to → TypeGenre → belongs to → Genre.'
        ],
    }
};


function renderBanner_1(banner_data) {

    let bunner = '';

    bunner += '<div class="mainBlock_AB">';
    bunner += '<h2 class ="text-center text-xl font-bold text-green-900 py-5">' + banner_data.title_1 + '</h2>';
    bunner += '<section class="slidershow_AB">';
    bunner += '<div class="content_AB">';
    bunner += '<div class="contentCarousel_AB">';

    Object.keys(banner_data.showText).map(element => {

        bunner += '<figure class="shadow_AB shadow_AB_1 pt-2">';

        bunner += '<img ';
        bunner += 'src="/storage/images/banner/' + banner_data.showText[element][0] + '_280.png"' + ' alt=' + banner_data.showText[element][0];
        bunner += ' />';

        bunner += '<div class="text-center text-white title_banner mt-1">';

        bunner += '<h6 class="my-2"><u>' + banner_data.showText[element][1] + '</u></h6>';
        bunner += '<ul>' + banner_data.showText[element][2].map(el => '<li>' + el + '</el>') + '</ul>';
        bunner += '</div>';
        bunner += '</figure>';
    });

    bunner += '</div>';
    bunner += '</div>';
    bunner += '</section>';
    bunner += '</div>';



    let i = 0;

    let modal_w = '';

    modal_w += '<div class="main-modal_1 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">';
    modal_w += '<div class="border-2 border-red-800 modal-container bg-white mx-auto rounded-md z-50 overflow-y-auto" style="width:1280px; max-height:720px" >';
    modal_w += '<div class="modal-content py-4 text-left px-6">';

    modal_w += '<div class="flex justify-between items-top pb-2 ">';
    modal_w += '<div class="mr-3 text-center">';
    modal_w += '<p id="slider_crop_1" class="text-md md:text-xl xl:text-2xl font-bold" style="color:green">' + banner_data.showText[i][1] + '</p>';
    modal_w += '</div>';

    modal_w += '<div class="hidden sm:block mr-2 " style="max-width:70px; max-height:70px">';
    modal_w += '<img class="" src="/storage/images/banner/laravel-logo.png" alt="laravel-logo"  />';
    modal_w += '</div>';

    modal_w += '<div class="hidden sm:block sm:text-md xl:text-xl mr-2">';
    modal_w += '<p id="slider_crop_11">' + banner_data.showText[i][3] + '</p>';
    modal_w += '</div>';

    modal_w += '<div>';
    modal_w += '<button class="modal-close_1 cursor-pointer z-50 px-5 py-2  bg-red-800 text-white rounded-md ">&#10005;</button>';
    modal_w += '</div>';
    modal_w += '</div>';

    modal_w += '<div class="text-sm sm:hidden">';
    modal_w += '<p id="slider_crop_111">' + banner_data.showText[i][3] + '</p>';
    modal_w += '</div>';

    modal_w += '<div id="slider_table_1" class="my-5 " >';
    modal_w += '<img style="max-height:450px" class="mx-auto cursor-pointer" id="slider_img_1" src="/storage/images/banner/' + banner_data.showText[i][0] + '.png" alt=' + banner_data.showText[i][0] + '  />';
    modal_w += '</div>';

    modal_w += '<div class="flex justify-end pt-2 text-2xl ">';
    modal_w += '<button id="banner_minus_1"	class="px-5 py-2 mr-2 bg-green-800  text-white cursor-pointer rounded-md">&larr;</button>';
    modal_w += '<button id="banner_plus_1"	class="px-5 py-2  bg-green-800  text-white cursor-pointer rounded-md">&rarr;</button>';
    modal_w += '</div>';

    modal_w += '</div>';
    modal_w += '</div>';
    modal_w += '</div>';


    document.getElementById("banner_1").innerHTML = bunner + modal_w;

    document.querySelectorAll('.shadow_AB_1').forEach(element => {
        element.addEventListener('click', function () {
            modal_1.classList.remove('fadeOut');
            modal_1.classList.add('fadeIn');
            modal_1.style.display = 'flex';
        });
    });

    const modal_1 = document.querySelector('.main-modal_1');
    const closeButton_1 = document.querySelectorAll('.modal-close_1');

    const modalClose_1 = () => {
        modal_1.classList.remove('fadeIn');
        modal_1.classList.add('fadeOut');
        setTimeout(() => {
            modal_1.style.display = 'none';
        }, 200);
    }


    for (let i = 0; i < closeButton_1.length; i++) {

        const elements_1 = closeButton_1[i];

        elements_1.onclick = (e) => modalClose_1();

        modal_1.style.display = 'none';

        /* window.onclick = function (event) {
            if (event.target == modal_1) modalClose_1();
        } */
    }

    modal_1.onclick = function (event) {
        if (event.target == modal_1) modalClose_1();
    };



    function render_slider_content_1(i) {
        document.querySelector('#slider_img_1').setAttribute('src', '/storage/images/banner/' + banner_data.showText[i][0] + '.png');
        document.querySelector('#slider_img_1').setAttribute('alt', banner_data.showText[i][0]);

        document.querySelector('#slider_crop_1').innerHTML = banner_data.showText[i][1];
        document.querySelector('#slider_crop_11').innerHTML = banner_data.showText[i][3];
        document.querySelector('#slider_crop_111').innerHTML = banner_data.showText[i][3];

    };

    function plus_increment_1() {
        i < 8 ? i++ : i = 0;
        render_slider_content_1(i);
    };

    function minus_increment_1() {
        i == 0 ? i = 8 : i--;
        render_slider_content_1(i);
    }


    document.querySelector('#banner_plus_1').onclick = plus_increment_1;
    document.querySelector('#banner_minus_1').onclick = minus_increment_1;



    document.addEventListener('keydown', function (event) {
        if (event.code == 'ArrowRight') plus_increment_1();
        if (event.code == 'ArrowLeft') minus_increment_1()
    });

    document.querySelector('#slider_img_1').onclick = function (e) {
        if (document.fullscreenElement) {
            document.exitFullscreen()
        } else {
            document.querySelector('#slider_img_1').requestFullscreen();
        }
    }

    let touchStartX = 0;
    let touchEndX = 0;

    function touchMoveStart(TouchEvent) {
        touchStartX = TouchEvent.changedTouches[0].screenX;
        //console.log(touchStartX);
    }

    function touchMoveEnd(TouchEvent) {
        touchEndX = TouchEvent.changedTouches[0].screenX;
        //console.log(touchEndX);

        if (Math.abs(touchStartX - touchEndX) > 100) {
            if (touchStartX > touchEndX) {
                plus_increment_1();
            }
            else if (touchStartX < touchEndX) {
                minus_increment_1()
            }
        }
    }

    document.querySelector('#slider_img_1').addEventListener('touchstart', touchMoveStart);
    document.querySelector('#slider_img_1').addEventListener('touchend', touchMoveEnd);

}

onMounted(() => {
    renderBanner_1(banner_data);
});


//renderbunner_1(banner_data);


</script>

<template>
    <Head :title="title" />

    <Layout>

        <section class="w-full  px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">

            <div class="xl:flex  xl:space-x-2 mb-2">

                <div id="banner_1" class="w-full xl:w-6/12   xl:flex-grow ">
                </div>

            </div>

        </section>

    </Layout>
</template>

<style >
.mainBlock_AB {
    margin:40px 20px 20px 20px;
    padding: 10px;
    border: 3px solid orange;
    border-radius: 18px;
    background: linear-gradient(0deg, rgba(138, 237, 0, 05) 0%, rgba(252, 185, 5, 0.3) 100%);
    box-shadow: 0px 0px 8px 3px brown;
}

.slidershow_AB {
    margin: 0 auto 15px auto;
    padding-top: 50px;
    height: 610px;
    box-sizing: border-box;

    background: linear-gradient(to bottom, #16235e 0%, #020223 100%);

    box-shadow: 0px 0px 13px 5px #DB1242;
    border-radius: 8px;
    margin-top: 12px;
}

.content_AB {
    margin: -250px auto 0 auto;
    width: 260px;
    perspective: 1000px;
    position: relative;
    padding-top: 250px;
}

.contentCarousel_AB {
    width: 100%;
    position: absolute;
    float: right;
    animation: rotar 65s infinite linear;
    transform-style: preserve-3d;
}

.contentCarousel_AB:hover {
    animation-play-state: paused;
}

.contentCarousel_AB figure {
    width: 100%;
    height: 250px;
    border: 1px solid #4d444d;
    border-radius: 10px;
    overflow: hidden;
    position: absolute;
    box-shadow: 0px 0px 4px 2px rgb(238, 218, 192);

    /* background: linear-gradient(to bottom, #16235e 0%, #020223 100%); */
}

.shadow_AB {
    position: absolute;
    border-radius: 3px;
}

.contentCarousel_AB img {
    image-rendering: auto;
    transition: all 300ms;
    width: 100%;
    border-radius: 6px;
    border:3px solid darkorange;
}

.contentCarousel_AB img:hover {
    cursor: pointer;
    transform: scale(1.02);
    transition: all 300ms;
}

@keyframes rotar {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(-360deg);
    }
}


@media screen and (min-width:350px) {
    figure .title_banner {
        font-size: 8px;
    }

    .slidershow_AB {
        padding-top: 30px;
        height: 230px;
    }

    .content_AB {
        width: 98px;
        perspective: 1100px;
        margin: -170px auto 0 auto;
        padding-top: 170px;
    }

    .contentCarousel_AB figure {
        height: 140px;
        box-shadow: 0px 0px 2px 1px rgb(238, 218, 192);
    }

    .contentCarousel_AB figure:nth-child(1) {
        transform: rotateY(0deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(2) {
        transform: rotateY(40deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(3) {
        transform: rotateY(80deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(4) {
        transform: rotateY(120deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(5) {
        transform: rotateY(160deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(6) {
        transform: rotateY(200deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(7) {
        transform: rotateY(240deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(8) {
        transform: rotateY(280deg) translateZ(140px);
    }

    .contentCarousel_AB figure:nth-child(9) {
        transform: rotateY(320deg) translateZ(140px);
    }
}

@media screen and (min-width:530px) {
    figure .title_banner {
        font-size: 12px;
    }

    .slidershow_AB {
        padding-top: 40px;
        height: 325px;
    }

    .content_AB {
        width: 140px;
        perspective: 1300px;
        margin: -230px auto 0 auto;
        padding-top: 230px;
    }

    .contentCarousel_AB figure {

        height: 190px;
        box-shadow: 0px 0px 2px 1px rgb(238, 218, 192);
    }

    .contentCarousel_AB figure:nth-child(1) {
        transform: rotateY(0deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(2) {
        transform: rotateY(40deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(3) {
        transform: rotateY(80deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(4) {
        transform: rotateY(120deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(5) {
        transform: rotateY(160deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(6) {
        transform: rotateY(200deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(7) {
        transform: rotateY(240deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(8) {
        transform: rotateY(280deg) translateZ(220px);
    }

    .contentCarousel_AB figure:nth-child(9) {
        transform: rotateY(320deg) translateZ(220px);
    }
}


@media screen and (min-width:710px) {
    figure .title_banner {
        font-size: 14px;
    }

    .slidershow_AB {
        padding-top: 45px;
        height: 435px;
    }

    .content_AB {
        width: 190px;
        perspective: 1300px;
        margin: -240px auto 0 auto;
        padding-top: 260px;
    }

    .contentCarousel_AB figure {

        height: 210px;
        box-shadow: 0px 0px 2px 1px rgb(238, 218, 192);
    }

    .contentCarousel_AB figure:nth-child(1) {
        transform: rotateY(0deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(2) {
        transform: rotateY(40deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(3) {
        transform: rotateY(80deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(4) {
        transform: rotateY(120deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(5) {
        transform: rotateY(160deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(6) {
        transform: rotateY(200deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(7) {
        transform: rotateY(240deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(8) {
        transform: rotateY(280deg) translateZ(280px);
    }

    .contentCarousel_AB figure:nth-child(9) {
        transform: rotateY(320deg) translateZ(280px);
    }
}

@media screen and (min-width:1020px) {
    figure .title_banner {
        font-size: 22px;
    }

    .slidershow_AB {
        padding-top: 50px;
        height: 500px;
    }

    .content_AB {
        width: 280px;
        perspective: 2000px;
        margin: -215px auto 0 auto;
        padding-top: 215px;
    }

    .contentCarousel_AB figure {
        height: 300px;
        box-shadow: 0px 0px 2px 1px rgb(238, 218, 192);
    }

    .contentCarousel_AB figure:nth-child(1) {
        transform: rotateY(0deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(2) {
        transform: rotateY(40deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(3) {
        transform: rotateY(80deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(4) {
        transform: rotateY(120deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(5) {
        transform: rotateY(160deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(6) {
        transform: rotateY(200deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(7) {
        transform: rotateY(240deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(8) {
        transform: rotateY(280deg) translateZ(420px);
    }

    .contentCarousel_AB figure:nth-child(9) {
        transform: rotateY(320deg) translateZ(420px);
    }
}

@media screen and (min-width:1400px) {
    figure .title_banner {
        font-size: 22px;
    }

    .slidershow_AB {
        padding-top: 50px;
        height: 550px;
        margin: 20px 100px;
    }

    .content_AB {
        width: 300px;
        perspective: 2000px;
        margin: -220px auto 0 auto;
        padding-top: 220px;
    }

    .contentCarousel_AB figure {
        height: 300px;
        box-shadow: 0px 0px 2px 1px rgb(238, 218, 192);
    }

    .contentCarousel_AB img {
        width: 280px;
        margin: 0 auto;
    }

    .contentCarousel_AB figure:nth-child(1) {
        transform: rotateY(0deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(2) {
        transform: rotateY(40deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(3) {
        transform: rotateY(80deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(4) {
        transform: rotateY(120deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(5) {
        transform: rotateY(160deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(6) {
        transform: rotateY(200deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(7) {
        transform: rotateY(240deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(8) {
        transform: rotateY(280deg) translateZ(520px);
    }

    .contentCarousel_AB figure:nth-child(9) {
        transform: rotateY(320deg) translateZ(520px);
    }
}
</style>
