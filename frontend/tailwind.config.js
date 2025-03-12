module.exports = {
  content: [
    "./views/**/*.html",
    "./components/**/*.html",
    "./index.html",
    "./*.html"
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#4f46e5',
        'primary-light': '#eef2ff',
        'primary-lighter': '#6366f1',
        'primary-dark': '#3730a3',
        'success': '#10b981',
        'danger': '#ef4444',
        'gray-50': '#f9fafb',
        'gray-100': '#f3f4f6',
        'gray-200': '#e5e7eb',
        'gray-300': '#d1d5db',
        'gray-400': '#9ca3af',
        'gray-500': '#6b7280',
        'gray-600': '#4b5563',
        'gray-700': '#374151',
        'gray-800': '#1f2937',
        'gray-900': '#111827',
      },
      fontFamily: {
        'heading': ['Merriweather', 'serif'],
        'body': ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Open Sans', 'Helvetica Neue', 'sans-serif'],
      },
      fontSize: {
        'xs': '0.7rem',
        'sm': '0.9rem',
        'md': '1rem',
        'lg': '1.2rem',
        'xl': '1.5rem',
        'xxl': '3.3rem',
      },
      spacing: {
        'xs': '0.5rem',
        'sm': '0.8rem',
        'md': '1rem',
        'lg': '1.5rem',
        'xl': '2rem',
        'xxl': '3rem',
        'xxxl': '5rem',
      },
      borderRadius: {
        'pill': '9999px',
        'md': '0.5rem',
      },
      transitionDuration: {
        'fast': '200ms',
        'normal': '300ms',
      },
      transitionTimingFunction: {
        'ease': 'ease',
      },
    },
  },
  plugins: [],
};