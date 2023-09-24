<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';


defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile" class="w-full ">
        <template #header class="">
            <div
                class="flex justify-between font-semibold text-xl text-gray-800 leading-tight border-b border-gray-200 pb-2">
                <h2 class="pr-2 ">
                    Profile
                </h2>

                <h2 class="px-1 border-x-3 border-black text-center">
                    <span class="hidden">{{ count_r = 0 }}</span>
                    <span v-for="name in $page.props.user_rp.roles.display_name" >
                        <span class="hidden">{{ count_r++ }}</span>
                        {{ name }}{{ $page.props.user_rp.roles.display_name.length == count_r ? '' : ',' }}
                    </span>
                </h2>

                <h2 class="text-center">
                    <span class="hidden">{{ count = 0 }}</span>
                    <span v-for="name in $page.props.user_rp.permissions_all.display_name" class="px-1 font-normal">
                        <span class="hidden">{{ count++ }}</span>
                        {{ name }}{{ $page.props.user_rp.permissions_all.display_name.length == count ? '.' : ',' }}
                    </span>
                    <span class="text-center text-red-800" v-if="$page.props.user_rp.permissions_personal.display_name.length > 0">
                        <br>Personal permissions:
                        <span class="hidden">{{ count_p = 0 }}</span>
                        <span v-for="name in $page.props.user_rp.permissions_personal.display_name"
                            class="px-1 font-normal">
                            <span class="hidden">{{ count_p++ }}</span>
                            {{ name }}{{ $page.props.user_rp.permissions_personal.display_name.length == count_p ? '.' : ','
                            }}
                        </span>
                    </span>
                </h2>
            </div>


        </template>

        <div class="bg-gradient-to-t from-green-300 to-orange-300">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm :requires-confirmation="confirmsTwoFactorAuthentication"
                        class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                    <SectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
