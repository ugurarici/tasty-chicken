<template>
  <app-layout :title="article.title">
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ article.title }}
        </h2>
        <div v-if="article.user_id == $page.props.user.id">
          <jet-secondary-button @click.prevent="editing = !editing">
            Edit
          </jet-secondary-button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          v-if="!editing"
          class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
        >
          <div class="p-6">
            {{ article.body }}
          </div>
        </div>
        <jet-form-section v-else @submitted="submitForm">
          <template #title> Update Article </template>

          <template #description>
            Enter the details of the article to update it.
          </template>

          <template #form>
            <!-- Title -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="title" value="Title" />
              <jet-input
                id="title"
                type="text"
                class="mt-1 block w-full"
                v-model="form.title"
                autocomplete="title"
              />
              <jet-input-error :message="form.errors.title" class="mt-2" />
            </div>

            <!-- Body -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="body" value="Body" />
              <textarea
                class="
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                  rounded-md
                  shadow-sm
                  mt-1
                  block
                  w-full
                "
                id="body"
                v-model="form.body"
              ></textarea>
              <jet-input-error :message="form.errors.body" class="mt-2" />
            </div>
          </template>

          <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
              Updated.
            </jet-action-message>

            <jet-secondary-button
              @click.prevent="editing = !editing"
              class="mr-3"
            >
              Close
            </jet-secondary-button>

            <jet-button
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Update
            </jet-button>
          </template>
        </jet-form-section>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";

export default defineComponent({
  props: ["article"],
  components: {
    AppLayout,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetActionMessage,
    JetSecondaryButton,
    JetDangerButton,
  },
  data() {
    return {
      editing: false,
      form: this.$inertia.form({
        title: this.article.title,
        body: this.article.body,
      }),
    };
  },
  methods: {
    submitForm() {
      this.form.put(this.route("articles.update", this.article), {
        errorBag: "updateArticle",
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.editing = false;
        },
      });
    },
  },
});
</script>
