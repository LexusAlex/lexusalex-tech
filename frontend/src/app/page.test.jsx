import '@testing-library/jest-dom'
import { render, screen } from '@testing-library/react'
import Home from "@/app/page";

describe('Home', () => {
    it('renders a text in home page', () => {
        render(<Home />)
        expect(screen.getByText(/Hello/i)).toBeInTheDocument();
    })
})