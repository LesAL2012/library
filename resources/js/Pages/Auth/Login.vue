<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import Layout from '@/Layouts/Layout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,

    provider: 'favicon.ico',
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <Layout>

        <AuthenticationCard class="w-full bg-gradient-to-t from-green-300 to-orange-300">
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <h3 class="text-center font-semibold">Login via social networks</h3>

            <div class="flex justify-around">
                <a class="w-1/2 border-3 border-orange-500 bg-orange-100 m-3 pt-1 rounded-xl hover:bg-yellow-100 pl-3"
                    href='/auth/google/redirect'>
                    Sign in with <img class="w-1/4 mx-3 my-1 inline-block" src="/storage/images/socialite/google.png"
                        alt="google.png">
                </a>

                <a class="w-1/2 border-3 border-orange-500 bg-orange-100 m-3 pt-1  rounded-xl hover:bg-yellow-100 pl-3"
                    href='/auth/github/redirect'>
                    Sign in with <img class="w-1/4 mx-3 my-1 inline-block" src="/storage/images/socialite/github.png"
                        alt="github.png">
                </a>
            </div>

            <div class="border-y-3 border-orange-500 bg-gray-100">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>Email for sample</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>user<span class="text-blue-700">Admin</span>@example.com</td>
                            <td rowspan="3" >Lib123456</td>
                        </tr>
                        <tr>
                            <td>user<span class="text-green-700">Moderator</span>@example.org</td>
                        </tr>
                        <tr>
                            <td>user<span class="text-orange-700">Reader</span>@example.org</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form @submit.prevent="submit" class="mt-2">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus
                        autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                        autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">

                    <Link v-if="canResetPassword" :href="route('register')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Registration form
                    </Link>


                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                    </Link>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticationCard>
    </Layout>
</template>

<style scoped>
table th,
table td {
    padding: 1px 15px;
    border: 1px solid darkgreen;

}

table {
    margin: 10px auto;
}

</style>
