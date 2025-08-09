<template>
    <div class="star-rating">
        <i
            v-for="n in 5"
            :key="n"
            :class="{'fa-star': true, 'fa-solid': rating >= n, 'fa-regular': rating < n}"
            @click="setRating(n)"
            @mouseover="previewRating = n"
            @mouseleave="previewRating = 0"
            :style="{ cursor: 'pointer', color: previewRating >= n || rating >= n ? 'gold' : '#ccc' }"
        ></i>
        <input type="hidden" :value="rating" name="rating">
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    projectId: {
        type: Number,
        required: true,
    },
    currentRating: {
        type: Number,
        default: 0,
    },
});

const rating = ref(props.currentRating);
const previewRating = ref(0);

const setRating = async (newRating) => {
    rating.value = newRating;

    try {
        const response = await axios.post(`/project/${props.projectId}/rate`, {
            rating: newRating
        });

        if (response.data.success) {
            window.location.reload();
        } else {
            alert(response.data.error); 
            rating.value = props.currentRating;
        }
    } catch (error) {
        if (error.response && error.response.data.error) {
            alert(error.response.data.error);
        } else {
            alert('Erro desconhecido ao salvar a avaliação.');
        }
    }
};
</script>

<style scoped>
.star-rating {
    display: inline-flex;
    gap: 0.3rem;
    font-size: 1.5rem;
}
</style>