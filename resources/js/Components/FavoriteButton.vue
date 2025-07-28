<template>
    <div class="flag-bookmark">
        <i
            :class="{'fa-bookmark': true, 'fa-solid': favorite, 'fa-regular': !favorite}"
            @click="setFavorite(!favorite)"
            @mouseover="previewFavValue = true"
            @mouseleave="previewFavValue = false"
            :style="{ cursor: 'pointer', color: previewFavValue || favorite ? 'red' : '#ccc' }"
        ></i>
        <input type="hidden" :value="favorite" name="favorite">
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
    currentFavValue: {
        type: Boolean,
        default: false,
    },
});

const favorite = ref(props.currentFavValue);
const previewFavValue = ref(false);

const setFavorite = async (newFavorite) => {
    try {
        const response = await axios.post(`/project/${props.projectId}/favorite`, {
            fav: newFavorite
        });

        if (response.data.success) {
            favorite.value = newFavorite;
        } else {
            alert(response.data.error); 
        }
    } catch (error) {
        if (error.response?.data?.error) {
            alert(error.response.data.error);
        } else {
            alert('Erro desconhecido ao salvar a avaliação.');
        }
    }
};
</script>