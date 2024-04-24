<script setup>

import {ref, watch, watchEffect} from "vue";
import {useRouter} from "vue-router";

let errors = [];
errors = ref(errors);

let data = ref();

let router = useRouter();

const submitForm = async function (evt) {
    evt.preventDefault();
    errors.value = [];
    const form = new FormData(document.querySelector('.new-ad-form'));
    const response = fetch('/api/adverts', {
        method: 'POST',
        body: form,
        headers: {
            Accept: 'application/json'
        }
    });

    data = response.then(res => res.json()).then(res => {
        if (res.id) {
            let path = '/advert/' + res.id;
            router.push({ path: path });
        } else {
            errors.value = res;
        }
    });
}
</script>

<template>
    <section class="new-ad-page">
        <form class="new-ad-form" @submit="submitForm">
            <label>
                Название объявления
                <input :class="{ error: errors.title }" name="title" type="text" >
                <span class="input-error" v-if="errors.title">{{ errors.title[0] }}</span>
            </label>
            <label>
                Цена
                <input :class="{ error: errors.price }" name="price" type="number" min="0" placeholder="1000" >
                <span class="input-error" v-if="errors.price">{{ errors.price[0] }}</span>
            </label>
            <label>
                Описание
                <textarea :class="{ error: errors.text }" name="text" placeholder="Текст объявления..."></textarea>
                <span class="input-error" v-if="errors.text">{{ errors.text[0] }}</span>
            </label>
            <label>
                Ссылки на фотографии
                <textarea :class="{ error: errors.photos }" name="photos" placeholder="До 3 штук, разделённых пробелами или запятой"></textarea>
                <span class="input-error" v-if="errors.photos">{{ errors.photos[0] }}</span>
            </label>
            <button class="new-ad-submit" type="submit">Отправить</button>
        </form>
    </section>
</template>

<style scoped>
.new-ad-page {
    width: 100%;
}

.new-ad-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    row-gap: 15px;
}

.new-ad-form > label {
    display: flex;
    flex-direction: column;
    row-gap: 15px;
    font-weight: bold;
}

.new-ad-form input,
.new-ad-form textarea {
    width: 250px;
    max-width: 250px;
    min-height: 45px;
    max-height: 145px;
    padding: 10px;
    place-self: center;
    font-family: Rubik, sans-serif;
    font-size: 18px;
}

input::placeholder,
textarea::placeholder {
    font-size: 15px;
    color: rgba(100, 149, 237, 0.75);
}

input:invalid {
    border-color: salmon;
}

.input-error {
    width: 250px;
    color: salmon;
}

button {
    max-width: 175px;
}

.error {
    border: 2px solid salmon;
}

.new-ad-submit {
    background-color: transparent;
    border: 1px dashed mediumvioletred;
    padding: 15px;
    color: mediumvioletred;
    font-size: 18px;
    font-weight: bold;
}

.new-ad-submit:hover {
    border-style: solid;
    text-decoration: underline solid mediumvioletred;
}

.new-ad-submit:active {
    border-color: mediumslateblue;
    color: mediumslateblue;
    text-decoration-color: mediumslateblue;
}
</style>
