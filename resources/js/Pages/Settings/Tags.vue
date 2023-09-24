<script setup>
import SettingsLayout from '@/Layouts/SettingsLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Pagination from '@/Includs/Pagination.vue';
import { getCookie, reloadPage } from '@/functions';

let messageSettings = getCookie('messageSettings') && getCookie('messageSettings') != '' ? true : false;

let props = defineProps({
    title: String,
    tags: Object,
});

const form = useForm({
    id: null,
    name: null,
});

function showFormEdit(id) {
    document.querySelectorAll('.action').forEach(element => {
        element.classList.toggle('hidden');
    });

    props.tags.data.map(element => {
        if (element.id == id) {
            form.id = id;
            form.name = element.name
        }
    });

    document.querySelector('.form-tag-' + id).classList.remove('hidden');
    document.querySelector('.table-tag-' + id).classList.add('hidden');
    document.querySelector('.btnShowAdd').classList.add('hidden');
}

function showFormAdd() {
    form.name = null;
    document.querySelectorAll('.action').forEach(element => {
        element.classList.toggle('hidden');
    });

    document.querySelector('.addForm').classList.remove('hidden');
    document.querySelector('.btnShowAdd').classList.add('hidden');
}



function update(id) {

    form.put(route('tags.update', id));

   /*  router.post(route('tags.update', id), {
        _method: 'put',
        name: form.name,
    }); */

    reloadPage();
};

function create() {

    form.post(route('tags.store'));

    reloadPage();
};

function destroy(id) {

    let books_count = 0;

    props.tags.data.map(element => {
        if (element.id == id) {
            form.id = id;
            form.name = element.name;
            books_count = element.books_count
        }
    });

    if (confirm(`Are you sure you want to Delete this tags? \n
    Tag - ${form.name} \n
    ID - ${form.id}\n`)) {

        if (books_count == 0) {
            router.post(route('tags.destroy', form.id), {
                _method: 'delete',
            });
            reloadPage();

        } else {
            alert('This tag has ' + books_count + ' books in the system, not NULL!\nThe number of books must be zero.');
        }
    }
};

document.addEventListener('keydown', (event) => {
    if (event.code == 'Escape') {
        document.querySelectorAll('.action').forEach(element => {
            element.classList.remove('hidden');
        });
        document.querySelectorAll('.form-tag').forEach(element => {
            element.classList.add('hidden');
        });
        document.querySelectorAll('.table-tag').forEach(element => {
            element.classList.remove('hidden');
        });
        document.querySelector('.btnShowAdd').classList.remove('hidden');
        document.querySelector('.addForm').classList.add('hidden');

    }
}, false);



//console.log(props.writers.data);

</script>


<template>
    <Head :title="props.title" />

    <SettingsLayout>

        <div v-if="messageSettings"
            class="text-center text-4xl text-white m-2 bg-green-900 rounded-xl border-3 border-white">
            {{ getCookie('messageSettings') }}
        </div>

        <h1 class="text-4xl py-2 text-center font-bold">Tags</h1>
        <p class="text-xs text-center text-red-700">Actions - Admin or Moderator</p>
        <Pagination class="w-full" :links="props.tags.links" />


        <table class="table-auto text-2xl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>
                        Tag

                        <button @click="showFormAdd" class="btnShowAdd float-right text-xl px-2
                        border-2 border-black text-white
                        bg-blue-600 rounded-md
                        hover:bg-blue-700"
                        v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')"
                        >
                            Add ...
                        </button>
                    </th>
                    <th> Books </th>
                    <th
                    v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')"
                    >Action</th>
                </tr>
            </thead>
            <tbody>

                <tr class="addForm h-12 hidden">
                    <td></td>
                    <td>

                        <form @submit.prevent="create()">

                            <input id="id_name_create" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                placeholder="Add a new tag name" type="text"
                                class="w-full font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">
                                <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>
                        </form>

                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr v-for="tag in props.tags.data">

                    <td>{{ tag.id }}</td>
                    <td class="w-96">

                        <div :class="'table-tag-' + tag.id + ' table-tag'">
                            {{ tag.name }}
                        </div>

                        <form @submit.prevent="update(tag.id)" :class="'form-tag-' + tag.id + ' form-tag hidden'">

                            <input id="id_name" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                type="text" class="w-full font-bold bg-gray-300 rounded-2xl text-xl border-2 border-black">
                                <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>

                        </form>

                    </td>
                    <td class="text-center">{{ tag.books_count }}</td>
                    <td class="text-center w-48"
                    v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')"
                    >

                        <div class="action flex justify-around">

                            <svg @click="showFormEdit(tag.id)" xmlns="http://www.w3.org/2000/svg" fill="lightblue"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 inline rounded-md hover:bg-indigo-300 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>

                            <svg @click="destroy(tag.id)" xmlns="http://www.w3.org/2000/svg" fill="lightcoral"
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



        <Pagination class="w-full" :links="props.tags.links" />
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
