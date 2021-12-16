<template>
    <main class="signup-main">
        <RegisterForm />
    </main>
</template>

<script>
    import RegisterForm from "../widgets/auth/RegisterForm";
    export default {
        components: {
            RegisterForm,
        },
    };
</script>