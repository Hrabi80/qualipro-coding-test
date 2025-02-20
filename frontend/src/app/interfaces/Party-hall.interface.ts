import { Concert } from "./concert.interface";

export interface PartyHall {
    id?: number;
    name: string;
    address: string;
    city: string;
    concerts?:[Concert]
}