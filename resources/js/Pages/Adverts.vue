<script setup>

import {ref} from "vue";
import {useFetch} from "../fetch.js";

let url = ref('/api/adverts');
const {data, error} = useFetch(url);

</script>

<template>
    <section class="index-page">
        <div class="controls">

            <router-link class="new-ad-link" to="/advert/add">
                + объявление
            </router-link>

            <div class="filter-option">
                <p class="filter-label">По цене</p>
                <button :class="{ active: url.includes('price/desc')}" @click="url='/api/adverts/price/desc'">от большей к меньшей</button>
                <button :class="{ active: url.includes('price/asc')}" @click="url='/api/adverts/price/asc'">от меньшей к большей</button>
            </div>
            <div class="filter-option">
                <p class="filter-label">По дате</p>
                <button :class="{ active: url.includes('date/desc')}" @click="url='/api/adverts/date/desc'">от новых к старым</button>
                <button :class="{ active: url.includes('date/asc')}" @click="url='/api/adverts/date/asc'">от старых к новым</button>
            </div>
        </div>

        <div v-if="data">
            <ul class="adverts-list">
                <li class="adverts-item" v-for="ad in data.data">
                    <router-link :to="`/advert/${ad.id}`">
                        <h2>{{ ad.title }}</h2>
                    </router-link>
                    <div class="ad-info">
                        <img class="ad-info-photo" v-if="ad.photo" :src="ad.photo" width="200" alt="Фотография из объявления">
                        <img class="ad-info-photo" v-else src="../../../resources/img/hamster2.png" width="200" alt="Фотография из объявления">
                        <p class="ad-info-price">Цена: <span> {{ ad.price }}р.</span></p>
                    </div>
                </li>
            </ul>
            <div v-if="data.links">
                <ul class="pagination">
                    <li v-if="data.meta.links" @click="url=page.url"  v-for="page in data.meta.links">
                        <button :class="page.active ? 'active' : ''" class="pagination-button" type="button">{{ page.label }}</button>
                    </li>
                </ul>
            </div>
        </div>

        <div v-else>
            <p>Загружается!</p>
        </div>
    </section>
</template>

<style scoped>
.index-page {
    display: flex;
    flex-direction: column;
}

p {
    margin: 0;
}

.controls {
    margin-bottom: 15px;
    padding: 15px;
    width: 80%;
    height: 25%;
    place-self: center;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    border-radius: 5px;
    color: navy;
}

.filter-option {
    display: flex;
    flex-direction: column;
    column-gap: 5px;
    justify-content: center;
    padding: 15px;
}

.filter-option > button {
    margin-bottom: 5px;
    background-color: transparent;
    border: none;
    color: darkslategray;
    font-size: 16px;
    text-align: left;
    cursor: pointer;
}

.filter-option > button.active {
    color: mediumvioletred;
    text-decoration: underline solid mediumvioletred;
}

.filter-option > button:hover {
    color: mediumaquamarine;
}

.filter-option > button:active {
    color: darkcyan;
}

.filter-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.new-ad-link {
    padding: 12px;
    color: firebrick;
    font-weight: bold;
    border: 2px solid navy;
    background-color: ghostwhite;
    place-self: center;
}

.new-ad-link:hover {
    background-color: cornflowerblue;
    color: navy;
    border-color: indigo;
}

.adverts-list {
    display: flex;
    flex-flow: row wrap;
    place-content: center;
    gap: 15px;
}

.adverts-item {
    width: 350px;
    height: 250px;
    padding: 15px;
    display: grid;
    border: 2px solid cornflowerblue;
    list-style: none;
    flex-grow: 0;
    box-shadow: 2px 2px 12px #cbd5e0;
}

.adverts-item > a {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.adverts-item > a > h2 {
    margin: 0 0 15px;
    color: cornflowerblue;
}

.adverts-item > a > h2:hover {
    color: firebrick;
}

.adverts-item > a > h2:active {
    color: darkslategray;
}

.adverts-item > a:visited > h2 {
    color: rebeccapurple;
}

.adverts-item:has(a:visited) {
    border-color: rebeccapurple;
}

.ad-info {
    display: grid;
    grid-template-columns: 1fr 3fr;
    justify-items: end;
    place-self: end;
}

.ad-info-photo {
    object-fit: cover;
    height: 200px;
}

.ad-info-price {
    grid-column-start: -1;
    font-weight: bold;
    color: navy;
}

.pagination {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: center;
    column-gap: 5%;
}

.pagination > li {
    list-style: none;
}

.pagination-button {
    padding: 10px;
    font-size: 16px;
    color: navy;
    border: 1px solid firebrick;
    border-radius: 5%;
    background-color: transparent;
    cursor: pointer;
}

.pagination > li:first-child > .pagination-button,
.pagination > li:last-child > .pagination-button {
    display: none;
}

.pagination-button.active {
    background-color: lightcoral;
}

.pagination-button:hover {
    background-color: lightsteelblue;
}
</style>
