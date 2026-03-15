import type { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg
            {...props}
            viewBox="0 0 100 100"
            xmlns="http://www.w3.org/2000/svg"
        >
            <rect
                x="47"
                y="5"
                width="6"
                height="90"
                fill="currentColor"
                rx="1"
            />
            <text
                x="42"
                y="45"
                text-anchor="end"
                font-family="'Geo', sans-serif"
                font-size="36"
                font-weight="700"
                fill="currentColor"
            >
                U
            </text>
            <text
                x="58"
                y="88"
                text-anchor="start"
                font-family="'Geo', sans-serif"
                font-size="36"
                font-weight="700"
                fill="currentColor"
            >
                M
            </text>
        </svg>
    );
}
