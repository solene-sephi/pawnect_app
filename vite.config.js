import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [symfonyPlugin(), tailwindcss()],
  build: {
    rollupOptions: {
      input: {
        app: "./assets/app.js",
      },
    },
  },
});
