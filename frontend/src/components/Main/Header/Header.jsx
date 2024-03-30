import {
    Avatar,
    Box,
    Button,
    ButtonGroup,
    Center,
    Container,
    Flex,
    Heading,
    HStack, Icon, SimpleGrid,
    Spacer, Square,
    Stack,
    Text, Wrap, WrapItem
} from "@chakra-ui/react";
import {FaDiceD20} from "react-icons/fa6";

export default function Header() {
    return (
        <>
            <Container maxW={{ base: "85%"}}>
                <SimpleGrid gap={'5px'} gridTemplateColumns={"repeat(10, 1fr)"} gridTemplateRows={"5.5rem"}>
                    <Box margin={'auto'}>
                        <FaDiceD20 color={'green'} size={'50'} fontSize='1.5rem' />
                    </Box>
                </SimpleGrid>
            </Container>
        </>
    );
}
