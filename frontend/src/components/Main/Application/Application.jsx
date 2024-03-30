import MainGrid from "@/components/Main/MainGrid/MainGrid";

export default function Application({ children }) {
    return (
        <>
            <MainGrid>{children}</MainGrid>
        </>
    );
}