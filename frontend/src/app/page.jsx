'use client';

import Link from "next/link";
import {
  Button,
  Grid,
  GridItem,
  Modal, ModalBody, ModalCloseButton,
  ModalContent, ModalFooter,
  ModalHeader,
  ModalOverlay,
  Stack,
  Textarea, useDisclosure, useToast
} from "@chakra-ui/react";

export default function Home() {
  const { isOpen, onOpen, onClose } = useDisclosure()
  const toast = useToast()
  return (
      <main>
        <Link className="btn btn-light" href="/login">Login</Link>
        <Button onClick={onOpen}>Open Modal</Button>
        <Button
            onClick={() =>
                toast({
                  title: 'Account created.',
                  description: "We've created your account for you.",
                  status: 'loading',
                  duration: 9000,
                  isClosable: true,
                })
            }
        >
          Show Toast
        </Button>
        <Modal
            isCentered
            onClose={onClose}
            isOpen={isOpen}
            motionPreset='slideInTop'
        >
          <ModalOverlay />
          <ModalContent>
            <ModalHeader>Русский текст</ModalHeader>
            <ModalCloseButton />
            <ModalBody>
              2134
            </ModalBody>
            <ModalFooter>
              <Button colorScheme='blue' mr={3} onClick={onClose}>
                Close
              </Button>
              <Button variant='yellow'>Secondary Action</Button>
            </ModalFooter>
          </ModalContent>
        </Modal>
      </main>
  );
}
