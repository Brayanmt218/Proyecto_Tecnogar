import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    baseUrl: 'http://127.0.0.1:8000', // <--- ¡CAMBIA ESTA LÍNEA!
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});