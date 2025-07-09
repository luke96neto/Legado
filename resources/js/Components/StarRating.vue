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

<script>
import { ref } from 'vue';
import axios from 'axios'; // Ou use fetch

export default {
    props: {
        projectId: {
            type: Number,
            required: true,
        },
        currentRating: {
            type: Number,
            default: 0,
        },
    },
    setup(props) {
        const rating = ref(props.currentRating);
        const previewRating = ref(0);

        const setRating = async (newRating) => {
            rating.value = newRating;

            try {
                const url = props.currentRating > 0
                    ? `/project/${props.projectId}/rate` // Rota de atualização
                    : `/project/${props.projectId}/rate`; // Rota de criação

                const method = props.currentRating > 0 ? 'put' : 'post';

                const response = await axios({
                    method: method,
                    url: url,
                    data: { rating: newRating },
                });

                if (response.data.success) {
                    window.location.reload(); // Recarrega a página para mostrar a nova média (simplificado)
                } else {
                    console.error('Erro ao salvar a avaliação:', response.data);
                    alert('Erro ao salvar a avaliação.');
                }
            } catch (error) {
                console.error('Erro na requisição:', error);
                alert('Erro na requisição para salvar a avaliação.');
            }
        };

        return {
            rating,
            previewRating,
            setRating,
        };
    },
};
</script>

<style scoped>
.star-rating {
    display: inline-flex;
    gap: 0.3rem;
    font-size: 1.5rem;
}
</style>