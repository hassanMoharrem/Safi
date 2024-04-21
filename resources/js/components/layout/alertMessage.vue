<script>
export default {
    props: [
        'successMsg'
    ],
}
</script>

<template>
    <div
         class="transition bg-sub px-4 py-2 border-start border-success border-2 rounded-3 shadow position-fixed bottom-0 mx-4 my-5">
        <img :src="'../assets/images/flashMsg.png'" class="d-inline-block" :width="'50'" :height="'50'" alt="img">
        <div class="d-inline-block align-middle mx-2 text-center">
            <h4 class="mb-1 text-success">Alert</h4>
            <h5 class="ms-1">{{ successMsg }}</h5>
        </div>
    </div>
</template>
