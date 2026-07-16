<template>
    <div v-if="open" class="modal-overlay">
        <div class="modal">
            <div class="modal__header">
                <h3 class="modal__title">
                    {{ isEditing ? 'Editar Categoría' : 'Nueva Categoría' }}
                </h3>
                <button @click="emit('close')" type="button" class="modal__close">
                    <span class="visually-hidden">Cerrar modal</span>
                    &times;
                </button>
            </div>

            <form @submit.prevent="emit('submit')" class="modal__body">
                <div class="form-group">
                    <div>
                        <label for="nombre" class="form-label">Nombre</label>
                        <input v-model="form.nombre" type="text" id="nombre" class="form-control" placeholder="Ej. Pinturas en Lienzo" required>
                        <span v-if="form.errors.nombre" class="form-error">{{ form.errors.nombre }}</span>
                    </div>
                    <div>
                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                        <textarea v-model="form.descripcion" id="descripcion" rows="3" class="form-control" placeholder="Detalles de esta categoría..."></textarea>
                        <span v-if="form.errors.descripcion" class="form-error">{{ form.errors.descripcion }}</span>
                    </div>
                </div>

                <div class="modal__footer">
                    <Button type="button" variant="outline" @click="emit('close')">Cancelar</Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ isEditing ? 'Actualizar' : 'Guardar' }}
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import type { InertiaForm } from '@inertiajs/vue3';

interface CategoriaForm {
    nombre: string;
    descripcion: string;
}

defineProps<{
    open: boolean;
    isEditing: boolean;
    form: InertiaForm<CategoriaForm>;
}>();

const emit = defineEmits<{
    close: [];
    submit: [];
}>();
</script>
