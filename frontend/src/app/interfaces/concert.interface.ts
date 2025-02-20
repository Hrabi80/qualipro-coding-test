import { Band } from "./band.interface";
import { PartyHall } from "./Party-hall.interface";

export interface Concert {
    id?: number;
    date: Date;
 //   bands:[Band];
    hall: PartyHall;
}