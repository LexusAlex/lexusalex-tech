import {Heading, Text} from "@chakra-ui/react";

export default function Home()
{
    return (
    <>
        <Heading as='h1' size='4xl' noOfLines={1}>
            (4xl) In love with React & Next
        </Heading>
        <Text>Контент главной страницы</Text>
    </>
    )
}