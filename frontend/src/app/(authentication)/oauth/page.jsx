import {
    AbsoluteCenter,
    Box,
    Button, ButtonGroup,
    Card,
    CardBody, CardFooter, CardHeader,
    Center, Divider, Flex, Grid, GridItem,
    IconButton, SimpleGrid, Spacer,
    Stat,
    StatHelpText,
    StatLabel,
    StatNumber,
    Text, Wrap, WrapItem
} from "@chakra-ui/react";
import NextLink from "next/link";

export default function OAuth() {

    return (
            <SimpleGrid minChildWidth='120px' gridTemplateRows={"auto"}>
                <Center>
                    <Card align='center' variant={'outline'} size={'md'} maxW='md' justifyContent={'center'}>
                        <CardBody>
                            <Text fontSize='md'>Спасибо, что залогинились</Text>
                        </CardBody>
                        <CardFooter>
                            <Button colorScheme='blue' as={NextLink} href="/">На главную</Button>
                        </CardFooter>
                    </Card>
                </Center>
            </SimpleGrid>

    );
}