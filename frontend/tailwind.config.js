module.exports = {
  content: ["./**/*.html"], // Scan all HTML files in subdirectories
  theme: {
    extend: {
      colors: {
        'primary-blue': '#0057b8',
        'primary-blue-dark': '#004c9e',
        'primary-blue-light': '#e6f0fa',
        'black': '#000000',
        'dark-gray': '#333333',
        'medium-gray': '#666666',
        'light-gray': '#999999',
        'ultra-light-gray': '#e0e0e0',
        'white': '#ffffff',
        'text-primary': '#333333', // using var(--dark-gray)
        'text-secondary': '#666666', // using var(--medium-gray)
        'text-accent': '#0057b8', // using var(--primary-blue)
        'border-color': '#e0e0e0', // using var(--ultra-light-gray)
      },
      fontFamily: {
        'heading': ['Merriweather', 'serif'],
        'body': ['Arial', 'sans-serif'],
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