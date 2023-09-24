<script setup>
import SettingsLayout from '@/Layouts/SettingsLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Pagination from '@/Includs/Pagination.vue';
import { getCookie, reloadPage } from '@/functions';

let messageSettings = getCookie('messageSettings') && getCookie('messageSettings') != '' ? true : false;

let props = defineProps({
    title: String,
    type_genres: Object,
    genres: Object,
});

const form = useForm({
    id: null,
    name: null,
    genre_id: null,
});

function showFormEdit(id) {
    document.querySelectorAll('.action').forEach(element => {
        element.classList.toggle('hidden');
    });

    props.type_genres.data.map(element => {
        if (element.id == id) {
            form.id = id;
            form.name = element.name
            form.genre_id = element.genre.id
        }
    });



    document.querySelectorAll('.form-type_genre-' + id).forEach(element => {
        element.classList.remove('hidden');
    });
    document.querySelectorAll('.table-type_genre-' + id).forEach(element => {
        element.classList.add('hidden');
    });
    document.querySelector('.btnShowAdd').classList.add('hidden');
}

function showFormAdd() {
    form.name = null;
    form.genre_id = null;
    document.querySelectorAll('.action').forEach(element => {
        element.classList.toggle('hidden');
    });

    document.querySelector('.addForm').classList.remove('hidden');
    document.querySelector('.btnShowAdd').classList.add('hidden');
}



function update(id) {

    console.log(id);

    router.post(route('type_genres.update', id), {
        _method: 'put',
        name: form.name,
        genre_id: form.genre_id,
    });

    reloadPage();
};

function create() {

    form.post(route('type_genres.store'));

    reloadPage();
};

function destroy(id) {

    let books_count = 0;

    props.type_genres.data.map(element => {
        if (element.id == id) {
            form.id = id;
            form.name = element.name;
            books_count = element.books_count
        }
    });

    if (confirm(`Are you sure you want to Delete this type of genre? \n
    Type of genre - ${form.name} \n
    ID - ${form.id}\n`)) {

        if (books_count == 0) {
            router.post(route('type_genres.destroy', form.id), {
                _method: 'delete',
            });
            reloadPage();

        } else {
            alert('This type of genre has ' + books_count + ' books in the system, not NULL!\nThe number of books must be zero.');
        }
    }
};

document.addEventListener('keydown', (event) => {
    if (event.code == 'Escape') {
        document.querySelectorAll('.action').forEach(element => {
            element.classList.remove('hidden');
        });
        document.querySelectorAll('.form-type_genre').forEach(element => {
            element.classList.add('hidden');
        });
        document.querySelectorAll('.table-type_genre').forEach(element => {
            element.classList.remove('hidden');
        });
        document.querySelector('.btnShowAdd').classList.remove('hidden');
        document.querySelector('.addForm').classList.add('hidden');

    }
}, false);

//console.log(props.type_genres.data);

</script>


<template>
    <Head :title="props.title" />

    <SettingsLayout>

        <div v-if="messageSettings"
            class="text-center text-4xl text-white m-2 bg-green-900 rounded-xl border-3 border-white">
            {{ getCookie('messageSettings') }}
        </div>

        <h1 class="text-4xl py-2 text-center font-bold">Type of genres</h1>
        <p class="text-xs text-center text-red-700">Actions - Admin or Moderator</p>
        <Pagination class="w-full" :links="props.type_genres.links" />


        <table class="table-auto text-2xl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>
                        Type of genre

                        <button @click="showFormAdd" class="btnShowAdd float-right text-xl px-2
                        border-2 border-black text-white
                        bg-blue-600 rounded-md
                        hover:bg-blue-700"
                            v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')">
                            Add ...
                        </button>
                    </th>
                    <th> Genre </th>
                    <th> Books </th>
                    <th
                        v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                <tr class="addForm h-12 hidden">
                    <td></td>

                    <td colspan="4" style="width: 500px;">

                        <form @submit.prevent="create()" class="flex justify-between">

                            <input id="id_name" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                placeholder="Add a new type of genre" type="text"
                                class="w-80 font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">


                            <select @change="setTypeGenreOption" id="id_genre" v-model="form.genre_id"
                                class="w-48 ml-10 font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">
                                <option v-for="genre in props.genres" :key="'genre_' + genre.id" :value="genre.id">
                                    {{ genre.id }}:{{ genre.name }}</option>
                            </select>

                            <div class="text-center w-36 py-2">

                            </div>

                            <button :disabled="form.processing" type="submit"
                                class="w-36 ml-3 font-bold bg-orange-300 rounded-2xl text-xl border-2 border-black hover:bg-orange-400">
                                Create
                            </button>

                        </form>

                    </td>






                </tr>

                <tr v-for="type_genre in props.type_genres.data">

                    <td>{{ type_genre.id }}</td>

                    <td :class="'w-96 table-type_genre-' + type_genre.id + ' table-type_genre'">
                        {{ type_genre.name }}
                    </td>

                    <td :class="'w-56 table-type_genre-' + type_genre.id + ' table-type_genre'">
                        {{ type_genre.genre.name }}
                    </td>


                    <td :class="'form-type_genre-' + type_genre.id + ' form-type_genre hidden'" colspan="4"
                        style="width: 500px;">

                        <form @submit.prevent="update(type_genre.id)" class="flex justify-between">

                            <input id="id_name" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                type="text" class="w-80 font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">


                            <select @change="setTypeGenreOption" id="id_genre" v-model="form.genre_id"
                                class="w-48 ml-10 font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">
                                <option v-for="genre in props.genres" :key="'genre_' + genre.id" :value="genre.id">
                                    {{ genre.id }}:{{ genre.name }}</option>
                            </select>

                            <div class="text-center w-36 py-2">
                                {{ type_genre.books_count }}
                            </div>

                            <button :disabled="form.processing" type="submit"
                                class="w-36 ml-3 font-bold bg-orange-300 rounded-2xl text-xl border-2 border-black hover:bg-orange-400">
                                Update
                            </button>

                        </form>

                    </td>


                    <td class="text-center w-36" :class="'table-type_genre-' + type_genre.id + ' table-type_genre'">{{
                        type_genre.books_count }}</td>
                    <td class="text-center w-48" :class="'table-type_genre-' + type_genre.id + ' table-type_genre'"
                    v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')"
                    >

                        <div class="action flex justify-around">

                            <svg @click="showFormEdit(type_genre.id)" xmlns="http://www.w3.org/2000/svg" fill="lightblue"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 inline rounded-md hover:bg-indigo-300 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>

                            <svg @click="destroy(type_genre.id)" xmlns="http://www.w3.org/2000/svg" fill="lightcoral"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 inline rounded-md hover:bg-indigo-300 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>



        <Pagination class="w-full" :links="props.type_genres.links" />
    </SettingsLayout>
</template>


<style scoped>
table th,
table td {
    padding: 5px 15px;
    border: 2px solid darkgreen;

}

table {
    margin: 10px auto;

}

/* .action{
    display: none;
} */
</style>
