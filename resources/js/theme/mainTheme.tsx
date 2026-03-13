import { createTheme } from '@mui/material/styles';

export const mainTheme = createTheme({
    cssVariables: true,

    palette: {
        primary: {
            main: '#26c6da',
        },
        secondary: {
            main: '#f50057',
        },
    },
    spacing: 8,
    shape: {
        borderRadius: 4,
    },
    components: {
        MuiButton: {},
    },

    typography: {
        h1: {
            fontSize: '5rem',
            lineHeight: 1.3,
            letterSpacing: '0em',
        },
    },
});
