<template>
    <main class="login-main">
        <LoginForm />
    </main>
</template>

<script>
    import LoginForm from "../widgets/auth/LoginForm";
    export default {
        components: {
            LoginForm,
        },
    };
</script>