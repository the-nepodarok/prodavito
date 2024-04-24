<script setup>

import {ref} from "vue";
import {useFetch} from "../fetch.js";
import {useRoute} from "vue-router";

const route = useRoute();

let url = ref('/api/adverts/' + route.params.id);
const {data, error} = useFetch(url);

const addParam = (param) => {
     if (!url.value.includes(param)) {
         url.value.includes('fields') ? url.value += (',' + param) : url.value += ('?fields=' + param);
     }
}
</script>

<template>
    <section class="advert-page">
        <div v-if="data">
            <h2 class="advert-title">
                {{ data.data.title }}
            </h2>
            <p>
                <span class="price-span">Цена:</span> {{ data.data.price }}р.
            </p>
            <p v-if="data.data.text">{{ data.data.text }}</p>
            <p class="show-text-button" @click="addParam('text')" v-else>Показать описание</p>
            <div v-if="data.data.photo">
                <ul class="photo-list" v-if="data.data.allphotos">
                    <li v-for="url in data.data.allphotos">
                        <img :src="url" width="500" alt="Фотография из объявления">
                    </li>
                </ul>
                <div v-else>
                    <img v-bind:src="data.data.photo" width="500" alt="Фотография из объявления">
                    <p class="show-photos-button" v-if="data.data.photos_count > 1" @click="addParam('allphotos')">
                        Загрузить все фото
                    </p>
                </div>

            </div>
        </div>
        <div v-else>
            <img src="../../img/hamster2.png" width="256" alt="Картинка-плейсхолдер">
            Загрузка...
        </div>
    </section>
</template>

<style scoped>
.advert-page {
    display: flex;
    flex-direction: row;
    place-content: center;
}

.advert-title {
    color: cornflowerblue;
}

.show-text-button,
.show-photos-button {
    color: cornflowerblue;
    cursor: pointer;
}

.show-text-button:hover,
.show-photos-button:hover {
    color: mediumvioletred;
}

.photo-list {
    display: flex;
    padding: 15px;
    flex-direction: column;
    row-gap: 15px;
    background-color: ghostwhite;
}

.photo-list > li {
    list-style: none;
}

.photo-list > li > img {
    object-fit: cover;
}
</style>
