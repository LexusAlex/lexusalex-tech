import {
    Avatar,
    Box,
    Button,
    ButtonGroup,
    Center,
    Container,
    Flex,
    Heading,
    HStack, Icon, Link, SimpleGrid,
    Spacer, Square,
    Stack,
    Text, Wrap, WrapItem
} from "@chakra-ui/react";
import {FaSquarespace} from "react-icons/fa6";
import NextLink from 'next/link'

export default function Header() {
    return (
        <>
            <Container maxW={{ base: "85%"}}>
                <SimpleGrid gap={'5px'} gridTemplateColumns={"repeat(10, 1fr)"} gridTemplateRows={"4rem"}>
                    <Box margin={'auto'} mr={"9px"}>
                        <FaSquarespace color={'green'} size={'50'} fontSize='1.5rem' />
                    </Box>
                    <Box margin={'auto'} ml={'0'}>
                        <Text fontWeight={'bold'} color={'green.700'}>Tech</Text>
                    </Box>
                    <Box></Box>
                    <Box></Box>
                    <Box></Box>
                    <Box></Box>
                    <Box></Box>
                    <Box></Box>
                    <Box></Box>
                    <Box margin={'auto'}>
                        <Button colorScheme={"teal"} as={NextLink} href="/login">Login</Button>
                    </Box>
                </SimpleGrid>
            </Container>
        </>
    );
}
