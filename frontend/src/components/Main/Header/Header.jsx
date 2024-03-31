import {
    Box,
    Button,
    Container,
    SimpleGrid,
    Text
} from "@chakra-ui/react";
import {FaSquarespace} from "react-icons/fa6";
import NextLink from 'next/link'
import {Data} from "@/components/Backend/Data";

export default async function Header() {
    return (
        <>
            <Container maxW={{ base: "85%"}}>
                <SimpleGrid gap={'5px'} gridTemplateColumns={"repeat(10, 1fr)"} gridTemplateRows={"4rem"}>
                    <Box margin={'auto'} mr={"9px"}>
                        <FaSquarespace color={'teal'} size={'50'} fontSize='1.5rem' />
                    </Box>
                    <Box margin={'auto'} ml={'0'}>
                        <Text hideBelow={"sm"} fontWeight={'bold'} color={'teal.700'}>Tech</Text>
                    </Box>
                    <Box>

                    </Box>
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
